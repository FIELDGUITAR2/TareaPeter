<?php
class Nomina {
    private $empleado;
    private $devengado;
    private $deduccion;
    private $totalAPagar;
    private $conexion; // Conexión a la base de datos

    public function __construct($empleado) {
        $this->empleado = $empleado;
        
        // Inicializamos el objeto de devengados con datos básicos
        $this->devengado = new procesoDevengados(
            $empleado->diasLaborados,
            0, // salarioSegunDias (se calculará más tarde)
            0, // vacacionesDisfrutadas (se calculará más tarde)
            0, // vacacionesCompensadas (se calculará más tarde)
            $empleado->tieneDerechoAuxTransporte ? true : false,
            0, // auxilioIncapacidadEmpleador
            0, // pagoIncapacidadEPS
            0, // pagoIncapacidadARL
            0, // extraTurno
            0, // recargoNocturno
            0, // horasDominicales
            $empleado->auxAlimentacionNoPrestacional ?? 0
        );
        
        // Establecer referencia al empleado en el objeto devengado
        $this->devengado->setEmpleado($empleado);
        
        // Inicializar conexión a la base de datos
        $this->iniciarConexion();
    }
    
    // Método para iniciar la conexión a la base de datos
    private function iniciarConexion() {
        try {
            // Configuración de la conexión a la base de datos
            $host = "localhost";
            $dbname = "nomina_db";
            $username = "usuario_nomina";
            $password = "contraseña_segura";
            
            // Crear conexión PDO
            $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Métodos para cálculos de nómina (los que ya tenías)
    public function procesarDevengados($datosHorasExtras = []) {
        // Código existente...
        // [Mantener el código existente]
    }

    public function procesarDeducciones($anticiposNomina = 0, $pagoVacaciones = 0, $diasVacaciones = 0, $fondoSolidaridad = 0, $prestamo = []) {
        // Código existente...
        // [Mantener el código existente]
    }

    // [Otros métodos existentes...]

    // Método para calcular el total a pagar
    public function calcularTotalAPagar() {
        $totalDevengado = $this->devengado->calcularTotalDevengado();
        $totalDeduccion = $this->deduccion->calcularTotalDeduccion();
        return $totalDevengado - $totalDeduccion;
    }

    // NUEVOS MÉTODOS CRUD

    // Obtener todas las nóminas
    public function obtenerNominas() {
        try {
            $consulta = "SELECT n.*, e.nombre, e.apellido 
                        FROM nominas n 
                        JOIN empleados e ON n.id_empleado = e.id 
                        ORDER BY n.fecha_creacion DESC";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener nóminas: " . $e->getMessage());
        }
    }

    // Obtener una nómina específica por ID
    public function obtenerNominaPorId($id) {
        try {
            $consulta = "SELECT n.*, e.nombre, e.apellido 
                        FROM nominas n 
                        JOIN empleados e ON n.id_empleado = e.id 
                        WHERE n.id = :id";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la nómina: " . $e->getMessage());
        }
    }

    // Agregar una nueva nómina
    public function agregarNomina($datos) {
        try {
            // Procesar los datos primero
            $totalDevengado = $this->procesarDevengados([
                'horasNocturnas' => $datos['horasNocturnas'] ?? 0,
                'horasExtrasDiurnas' => $datos['horasExtrasDiurnas'] ?? 0,
                'horasExtrasNocturnas' => $datos['horasExtrasNocturnas'] ?? 0,
                'horasDominicales' => $datos['horasDominicales'] ?? 0,
                'vacacionesCompensadas' => $datos['vacacionesCompensadas'] ?? 0,
                'incapacidadEmpleador' => $datos['incapacidadEmpleador'] ?? 0,
                'incapacidadEPS' => $datos['incapacidadEPS'] ?? 0,
                'incapacidadARL' => $datos['incapacidadARL'] ?? 0
            ]);
            
            $totalDeducciones = $this->procesarDeducciones(
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
            
            $totalAPagar = $this->calcularTotalAPagar();
            
            // Insertar en la base de datos
            $consulta = "INSERT INTO nominas 
                        (id_empleado, fecha_nomina, dias_laborados, total_devengado, 
                        total_deducciones, total_a_pagar, horas_nocturnas, 
                        horas_extras_diurnas, horas_extras_nocturnas, horas_dominicales, 
                        vacaciones_compensadas, fecha_creacion) 
                        VALUES 
                        (:id_empleado, :fecha_nomina, :dias_laborados, :total_devengado, 
                        :total_deducciones, :total_a_pagar, :horas_nocturnas, 
                        :horas_extras_diurnas, :horas_extras_nocturnas, :horas_dominicales, 
                        :vacaciones_compensadas, NOW())";
            
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id_empleado', $this->empleado->id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_nomina', $datos['fecha_nomina'], PDO::PARAM_STR);
            $stmt->bindParam(':dias_laborados', $this->empleado->diasLaborados, PDO::PARAM_INT);
            $stmt->bindParam(':total_devengado', $totalDevengado, PDO::PARAM_STR);
            $stmt->bindParam(':total_deducciones', $totalDeducciones, PDO::PARAM_STR);
            $stmt->bindParam(':total_a_pagar', $totalAPagar, PDO::PARAM_STR);
            $stmt->bindParam(':horas_nocturnas', $datos['horasNocturnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_extras_diurnas', $datos['horasExtrasDiurnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_extras_nocturnas', $datos['horasExtrasNocturnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_dominicales', $datos['horasDominicales'], PDO::PARAM_INT);
            $stmt->bindParam(':vacaciones_compensadas', $datos['vacacionesCompensadas'], PDO::PARAM_STR);
            
            $stmt->execute();
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error al agregar la nómina: " . $e->getMessage());
        }
    }

    // Actualizar una nómina existente
    public function actualizarNomina($id, $datos) {
        try {
            // Procesar los datos primero (similar a agregarNomina)
            $totalDevengado = $this->procesarDevengados([
                'horasNocturnas' => $datos['horasNocturnas'] ?? 0,
                'horasExtrasDiurnas' => $datos['horasExtrasDiurnas'] ?? 0,
                'horasExtrasNocturnas' => $datos['horasExtrasNocturnas'] ?? 0,
                'horasDominicales' => $datos['horasDominicales'] ?? 0,
                'vacacionesCompensadas' => $datos['vacacionesCompensadas'] ?? 0,
                'incapacidadEmpleador' => $datos['incapacidadEmpleador'] ?? 0,
                'incapacidadEPS' => $datos['incapacidadEPS'] ?? 0,
                'incapacidadARL' => $datos['incapacidadARL'] ?? 0
            ]);
            
            $totalDeducciones = $this->procesarDeducciones(
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
            
            $totalAPagar = $this->calcularTotalAPagar();
            
            // Actualizar en la base de datos
            $consulta = "UPDATE nominas SET 
                        fecha_nomina = :fecha_nomina, 
                        dias_laborados = :dias_laborados, 
                        total_devengado = :total_devengado, 
                        total_deducciones = :total_deducciones, 
                        total_a_pagar = :total_a_pagar, 
                        horas_nocturnas = :horas_nocturnas, 
                        horas_extras_diurnas = :horas_extras_diurnas, 
                        horas_extras_nocturnas = :horas_extras_nocturnas, 
                        horas_dominicales = :horas_dominicales, 
                        vacaciones_compensadas = :vacaciones_compensadas, 
                        fecha_actualizacion = NOW() 
                        WHERE id = :id";
            
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_nomina', $datos['fecha_nomina'], PDO::PARAM_STR);
            $stmt->bindParam(':dias_laborados', $this->empleado->diasLaborados, PDO::PARAM_INT);
            $stmt->bindParam(':total_devengado', $totalDevengado, PDO::PARAM_STR);
            $stmt->bindParam(':total_deducciones', $totalDeducciones, PDO::PARAM_STR);
            $stmt->bindParam(':total_a_pagar', $totalAPagar, PDO::PARAM_STR);
            $stmt->bindParam(':horas_nocturnas', $datos['horasNocturnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_extras_diurnas', $datos['horasExtrasDiurnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_extras_nocturnas', $datos['horasExtrasNocturnas'], PDO::PARAM_INT);
            $stmt->bindParam(':horas_dominicales', $datos['horasDominicales'], PDO::PARAM_INT);
            $stmt->bindParam(':vacaciones_compensadas', $datos['vacacionesCompensadas'], PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar la nómina: " . $e->getMessage());
        }
    }

    // Eliminar una nómina
    public function eliminarNomina($id) {
        try {
            $consulta = "DELETE FROM nominas WHERE id = :id";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar la nómina: " . $e->getMessage());
        }
    }

    public function getResumenNomina() {
        // Obtener todos los devengados
        $devengadoDetalle = [
            'salarioBase' => $this->empleado->salarioBase,
            'diasLaborados' => $this->empleado->diasLaborados,
            'salarioSegunDias' => $this->devengado->salarioSegunDias ?? 0,
            'auxilioTransporte' => $this->devengado->auxilioTransporte ?? 0,
            'horasExtrasDiurnas' => $this->devengado->horasExtrasDiurnas ?? 0,
            'valorHorasExtrasDiurnas' => $this->devengado->valorHorasExtrasDiurnas ?? 0,
            'horasExtrasNocturnas' => $this->devengado->horasExtrasNocturnas ?? 0,
            'valorHorasExtrasNocturnas' => $this->devengado->valorHorasExtrasNocturnas ?? 0,
            'recargoNocturno' => $this->devengado->recargoNocturno ?? 0,
            'valorRecargoNocturno' => $this->devengado->valorRecargoNocturno ?? 0,
            'horasDominicales' => $this->devengado->horasDominicales ?? 0,
            'valorHorasDominicales' => $this->devengado->valorHorasDominicales ?? 0,
            'vacacionesDisfrutadas' => $this->devengado->vacacionesDisfrutadas ?? 0,
            'valorVacacionesDisfrutadas' => $this->devengado->valorVacacionesDisfrutadas ?? 0,
            'vacacionesCompensadas' => $this->devengado->vacacionesCompensadas ?? 0,
            'valorVacacionesCompensadas' => $this->devengado->valorVacacionesCompensadas ?? 0,
            'auxilioIncapacidadEmpleador' => $this->devengado->auxilioIncapacidadEmpleador ?? 0,
            'pagoIncapacidadEPS' => $this->devengado->pagoIncapacidadEPS ?? 0,
            'pagoIncapacidadARL' => $this->devengado->pagoIncapacidadARL ?? 0,
            'auxAlimentacionNoPrestacional' => $this->devengado->auxAlimentacionNoPrestacional ?? 0,
            'totalDevengado' => $this->devengado->calcularTotalDevengado()
        ];
        
        // Obtener todas las deducciones
        $deduccionDetalle = [
            'salud' => $this->deduccion->salud ?? 0,
            'pension' => $this->deduccion->pension ?? 0,
            'fondoSolidaridad' => $this->deduccion->fondoSolidaridad ?? 0,
            'retencionFuente' => $this->deduccion->retencionFuente ?? 0,
            'anticiposNomina' => $this->deduccion->anticiposNomina ?? 0,
            'prestamo' => $this->deduccion->prestamo ?? 0,
            'pagoVacaciones' => $this->deduccion->pagoVacaciones ?? 0,
            'totalDeduccion' => $this->deduccion->calcularTotalDeduccion()
        ];
        
        // Datos del empleado
        $datosEmpleado = [
            'id' => $this->empleado->id ?? 0,
            'nombre' => $this->empleado->nombre ?? '',
            'apellido' => $this->empleado->apellido ?? '',
            'identificacion' => $this->empleado->identificacion ?? '',
            'salarioBase' => $this->empleado->salarioBase ?? 0,
            'tipoContrato' => $this->empleado->tipoContrato ?? '',
            'tieneDerechoAuxTransporte' => $this->empleado->tieneDerechoAuxTransporte ?? false,
        ];
        
        // Total a pagar
        $totalAPagar = $this->calcularTotalAPagar();
        
        // Compilar el resumen completo
        return [
            'empleado' => $datosEmpleado,
            'devengados' => $devengadoDetalle,
            'deducciones' => $deduccionDetalle,
            'totalAPagar' => $totalAPagar,
            'fechaProceso' => date('Y-m-d H:i:s')
        ];
    }

}
?>