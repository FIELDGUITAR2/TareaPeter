<?php
require_once 'Modelo/Nomina.php';
require_once 'Modelo/procesoDevengados.php';
require_once 'Modelo/procesoDeducciones.php';

class ControladorNomina {

    private $nomina;
    private $empleado;

    public function __construct($empleado) {
        $this->empleado = $empleado;
        // Inicializar la clase Nomina con el empleado
        $this->nomina = new Nomina($empleado);
    }

    // Mostrar todos los registros de nómina
    public function vistaNomina() {
        try {
            $listaNomina = $this->nomina->obtenerNominas();
            include 'Vista/vista_Nomina.php';
        } catch (Exception $e) {
            die("Error al cargar la vista de nómina: " . $e->getMessage());
        }
    }

    // Mostrar formulario de creación (si es por separado)
    public function mostrarFormulario() {
        include 'Vista/crear_Eliminar.php';
    }

    // Guardar o crear nuevo registro de nómina
    public function crearNomina($datos) {
        try {
            // Validar datos antes de enviarlos al modelo
            if (isset($datos['campo1'], $datos['campo2'], $datos['campo3'])) {
                $this->nomina->agregarNomina($datos);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("Datos incompletos para crear la nómina.");
            }
        } catch (Exception $e) {
            die("Error al crear la nómina: " . $e->getMessage());
        }
    }

    // Editar nómina
    public function editarNomina($id, $datosActualizados) {
        try {
            if (isset($id, $datosActualizados['campo1'], $datosActualizados['campo2'], $datosActualizados['campo3'])) {
                $this->nomina->actualizarNomina($id, $datosActualizados);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("Datos incompletos para actualizar la nómina.");
            }
        } catch (Exception $e) {
            die("Error al actualizar la nómina: " . $e->getMessage());
        }
    }

    // Eliminar una nómina
    public function eliminarNomina($id) {
        try {
            if (isset($id)) {
                $this->nomina->eliminarNomina($id);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("ID no proporcionado para eliminar la nómina.");
            }
        } catch (Exception $e) {
            die("Error al eliminar la nómina: " . $e->getMessage());
        }
    }

    // Calcular conceptos adicionales de nómina
    public function calcularConceptos($datos) {
        try {
            // Validar datos necesarios para los cálculos
            if (isset($datos['diasLaborados'], $datos['horasNocturnas'], $datos['horasExtrasDiurnas'], 
                      $datos['horasExtrasNocturnas'], $datos['horasDominicales'])) {
                
                // Preparar datos para horas extras y conceptos adicionales
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

                // Procesar devengados
                $totalDevengado = $this->nomina->procesarDevengados($datosHorasExtras);
                
                // Datos para deducciones
                $anticiposNomina = $datos['anticiposNomina'] ?? 0;
                $pagoVacaciones = $datos['pagoVacaciones'] ?? 0;
                $diasVacaciones = $datos['diasVacaciones'] ?? 0;
                $fondoSolidaridad = $datos['fondoSolidaridad'] ?? 0;
                $prestamo = [
                    'monto' => $datos['prestamo_monto'] ?? 0,
                    'cuotas' => $datos['prestamo_cuotas'] ?? 0,
                    'cuotasPagadas' => $datos['prestamo_cuotasPagadas'] ?? 0,
                    'valorCuota' => $datos['prestamo_valorCuota'] ?? 0
                ];
                
                // Procesar deducciones
                $totalDeducciones = $this->nomina->procesarDeducciones(
                    $anticiposNomina, 
                    $pagoVacaciones, 
                    $diasVacaciones, 
                    $fondoSolidaridad, 
                    $prestamo
                );
                
                // Calcular total a pagar
                $totalAPagar = $this->nomina->calcularTotalAPagar();
                
                // Obtener el resumen completo de la nómina
                $resumenNomina = $this->nomina->getResumenNomina();
                
                return $resumenNomina;
                
            } else {
                throw new Exception("Datos incompletos para realizar los cálculos.");
            }
        } catch (Exception $e) {
            die("Error al calcular los conceptos: " . $e->getMessage());
        }
    }

    // Mostrar resultados de los cálculos
    public function mostrarResultados($datos) {
        try {
            $resultados = $this->calcularConceptos($datos);
            include 'Vista/vista_Resultados.php';
        } catch (Exception $e) {
            die("Error al mostrar los resultados: " . $e->getMessage());
        }
    }
    
    // Método para generar reporte de nómina
    public function generarReporteNomina($idEmpleado) {
        try {
            // Obtener todos los datos del empleado necesarios para el cálculo
            $datosEmpleado = $this->obtenerDatosEmpleado($idEmpleado);
            
            // Preparar los datos para el cálculo
            $datos = [
                'diasLaborados' => $datosEmpleado['diasLaborados'],
                'horasNocturnas' => $datosEmpleado['horasNocturnas'],
                'horasExtrasDiurnas' => $datosEmpleado['horasExtrasDiurnas'],
                'horasExtrasNocturnas' => $datosEmpleado['horasExtrasNocturnas'],
                'horasDominicales' => $datosEmpleado['horasDominicales'],
                'vacacionesCompensadas' => $datosEmpleado['vacacionesCompensadas'],
                'incapacidadEmpleador' => $datosEmpleado['incapacidadEmpleador'],
                'incapacidadEPS' => $datosEmpleado['incapacidadEPS'],
                'incapacidadARL' => $datosEmpleado['incapacidadARL'],
                'anticiposNomina' => $datosEmpleado['anticiposNomina'],
                'pagoVacaciones' => $datosEmpleado['pagoVacaciones'],
                'diasVacaciones' => $datosEmpleado['diasVacaciones'],
                'fondoSolidaridad' => $datosEmpleado['fondoSolidaridad'],
                'prestamo_monto' => $datosEmpleado['prestamo_monto'],
                'prestamo_cuotas' => $datosEmpleado['prestamo_cuotas'],
                'prestamo_cuotasPagadas' => $datosEmpleado['prestamo_cuotasPagadas'],
                'prestamo_valorCuota' => $datosEmpleado['prestamo_valorCuota']
            ];
            
            // Calcular la nómina
            $resultados = $this->calcularConceptos($datos);
            
            // Generar PDF o formato necesario para el reporte
            $this->generarPDFNomina($resultados);
            
        } catch (Exception $e) {
            die("Error al generar el reporte de nómina: " . $e->getMessage());
        }
    }
    
    // Método para obtener datos del empleado (simulado)
    private function obtenerDatosEmpleado($idEmpleado) {
        // En un caso real, estos datos vendrían de la base de datos
        // Aquí solo simulamos para el ejemplo
        return [
            'diasLaborados' => 30,
            'horasNocturnas' => 10,
            'horasExtrasDiurnas' => 5,
            'horasExtrasNocturnas' => 3,
            'horasDominicales' => 8,
            'vacacionesCompensadas' => 0,
            'incapacidadEmpleador' => 0,
            'incapacidadEPS' => 0,
            'incapacidadARL' => 0,
            'anticiposNomina' => 0,
            'pagoVacaciones' => 0,
            'diasVacaciones' => 0,
            'fondoSolidaridad' => 0,
            'prestamo_monto' => 0,
            'prestamo_cuotas' => 0,
            'prestamo_cuotasPagadas' => 0,
            'prestamo_valorCuota' => 0
        ];
    }
    
    // Método para generar PDF (simulado)
    private function generarPDFNomina($resultados) {
        // Aquí iría la lógica para generar un PDF con los resultados
        // Por ejemplo, usando una librería como FPDF o TCPDF
        echo "Generando PDF con los resultados de la nómina...";
    }
}
?>