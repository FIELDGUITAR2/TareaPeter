<?php
require_once 'Modelo/Nomina.php';
require_once 'Modelo/Empleado.php';
require_once 'Modelo/procesoDevengados.php';
require_once 'Modelo/procesoDeducciones.php';

class ControladorNomina {
    private $pdo;
    private $nomina;
    private $empleado;

    public function __construct($empleado = null) {
        $this->pdo = new PDO('mysql:host=localhost;dbname=nomina_db', 'usuario_nomina', 'contraseña_segura');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ($empleado) {
            $this->empleado = $empleado;
            $this->nomina = new Nomina($empleado);
        }
    }

    // Método para procesar nómina individual
    public function procesarNominaIndividual($datos) {
        try {
            // Validación básica
            if (!$this->empleado) {
                throw new Exception("No se ha proporcionado un empleado válido.");
            }

            // Procesar devengados y deducciones
            $resultados = $this->calcularConceptos($datos);
            
            // Guardar en base de datos
            $nominaId = $this->guardarNominaIndividual($resultados);
            
            return [
                'success' => true,
                'nomina_id' => $nominaId,
                'resultados' => $resultados
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Método para procesar nómina grupal
    public function procesarNominaGrupal($datosNomina) {
        try {
            $this->pdo->beginTransaction();
            
            // 1. Crear registro de nómina grupal
            $stmt = $this->pdo->prepare("INSERT INTO nominas 
                (fecha_nomina, periodo, tipo, estado) 
                VALUES (?, ?, 'grupal', 'pendiente')");
            $stmt->execute([
                $datosNomina['fecha_nomina'],
                $datosNomina['periodo']
            ]);
            $nominaId = $this->pdo->lastInsertId();
            
            // 2. Procesar cada empleado
            $resultados = [];
            foreach ($datosNomina['empleados'] as $empleadoId => $datos) {
                $empleado = $this->obtenerEmpleado($empleadoId);
                $this->nomina = new Nomina($empleado);
                
                $resultado = $this->calcularConceptos($datos);
                $this->guardarNominaEmpleado($nominaId, $empleadoId, $resultado);
                $this->asignarNominaEmpleado($empleadoId, $nominaId);
                
                $resultados[$empleadoId] = $resultado;
            }
            
            $this->pdo->commit();
            
            return [
                'success' => true,
                'nomina_id' => $nominaId,
                'resultados' => $resultados
            ];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Método para calcular conceptos (similar al original pero mejorado)
    private function calcularConceptos($datos) {
        // Validación de datos requeridos
        $requeridos = ['diasLaborados', 'horasNocturnas', 'horasExtrasDiurnas', 
                      'horasExtrasNocturnas', 'horasDominicales'];
        foreach ($requeridos as $campo) {
            if (!isset($datos[$campo])) {
                throw new Exception("El campo $campo es requerido para el cálculo.");
            }
        }

        // Procesar devengados
        $datosHorasExtras = [
            'horasNocturnas' => $datos['horasNocturnas'],
            'horasExtrasDiurnas' => $datos['horasExtrasDiurnas'],
            'horasExtrasNocturnas' => $datos['horasExtrasNocturnas'],
            'horasDominicales' => $datos['horasDominicales'],
            'vacacionesCompensadas' => $datos['vacacionesCompensadas'] ?? 0,
            'incapacidadEmpleador' => $datos['incapacidadEmpleador'] ?? 0,
            'incapacidadEPS' => $datos['incapacidadEPS'] ?? 0,
            'incapacidadARL' => $datos['incapacidadARL'] ?? 0
        ];
        
        $totalDevengado = $this->nomina->procesarDevengados($datosHorasExtras);
        
        // Procesar deducciones
        $totalDeducciones = $this->nomina->procesarDeducciones(
            $datos['anticiposNomina'] ?? 0,
            $datos['pagoVacaciones'] ?? 0,
            $datos['diasVacaciones'] ?? 0,
            $datos['fondoSolidaridad'] ?? 0,
            [
                'monto' => $datos['prestamo_monto'] ?? 0,
                'cuotas' => $datos['prestamo_cuotas'] ?? 0,
                'cuotasPagadas' => $datos['prestamo_cuotasPagadas'] ?? 0,
                'valorCuota' => $datos['prestamo_valorCuota'] ?? 0
            ]
        );
        
        // Obtener resumen
        $resumen = $this->nomina->getResumenNomina();
        
        return [
            'empleado' => $this->empleado,
            'devengados' => $resumen['devengados'],
            'deducciones' => $resumen['deducciones'],
            'totalDevengado' => $resumen['totalDevengado'],
            'totalDeducciones' => $resumen['totalDeducciones'],
            'totalAPagar' => $resumen['totalAPagar']
        ];
    }

    // Métodos auxiliares para guardar en BD
    private function guardarNominaIndividual($resultados) {
        $stmt = $this->pdo->prepare("INSERT INTO nominas 
            (empleado_id, fecha_nomina, total_devengado, 
             total_deducciones, total_pagar, tipo, estado) 
            VALUES (?, NOW(), ?, ?, ?, 'individual', 'procesada')");
        
        $stmt->execute([
            $this->empleado->id,
            $resultados['totalDevengado'],
            $resultados['totalDeducciones'],
            $resultados['totalAPagar']
        ]);
        
        $nominaId = $this->pdo->lastInsertId();
        $this->asignarNominaEmpleado($this->empleado->id, $nominaId);
        
        return $nominaId;
    }

    private function guardarNominaEmpleado($nominaId, $empleadoId, $resultados) {
        $stmt = $this->pdo->prepare("INSERT INTO nomina_empleados 
            (nomina_id, empleado_id, datos_nomina, 
             total_devengado, total_deducciones, total_pagar) 
            VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $nominaId,
            $empleadoId,
            json_encode($resultados),
            $resultados['totalDevengado'],
            $resultados['totalDeducciones'],
            $resultados['totalAPagar']
        ]);
    }

    private function asignarNominaEmpleado($empleadoId, $nominaId) {
        $stmt = $this->pdo->prepare("UPDATE empleados SET nomina_id = ? WHERE id = ?");
        $stmt->execute([$nominaId, $empleadoId]);
    }

    // Métodos para vistas (similares a los originales)
    public function vistaNomina() {
        try {
            $nominas = $this->obtenerTodasNominas();
            include 'Vista/vista_Nomina.php';
        } catch (Exception $e) {
            die("Error al cargar la vista de nómina: " . $e->getMessage());
        }
    }

    public function mostrarResultados($datos) {
        try {
            $resultados = $this->calcularConceptos($datos);
            include 'Vista/vista_Resultados.php';
        } catch (Exception $e) {
            die("Error al mostrar los resultados: " . $e->getMessage());
        }
    }

    // Métodos para obtener datos
    private function obtenerEmpleado($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM empleados WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Empleado');
        return $stmt->fetch();
    }

    private function obtenerTodasNominas() {
        $stmt = $this->pdo->query("
            SELECT n.*, e.nombre, e.apellido 
            FROM nominas n
            LEFT JOIN empleados e ON n.empleado_id = e.id
            ORDER BY n.fecha_nomina DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Métodos para generar reportes (similares a los originales)
    public function generarReporteNomina($idNomina) {
        // Implementación similar a la original pero adaptada
    }
}