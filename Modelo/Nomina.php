<?php
class Nomina {
    public $empleado; // objeto de la clase Empleado
    public $salarioSegunDias;
    public $vacacionesDisfrutadas;
    public $vacacionesCompensadas;
    public $auxTransporte;
    public $incapacidadEmpleador;
    public $incapacidadEPS;
    public $incapacidadARL;
    public $extraTurno;
    public $recargoNocturno;
    public $horasDominicales;
    public $auxAlimentacion;
    public $totalDevengado;

    public $salud;
    public $pension;
    public $fondoSolidaridad;
    public $anticiposNomina;
    public $pagoVacaciones;

    public $prestamoMonto;
    public $cuotasDescontar;
    public $fechaDesembolso;
    public $cuotaPagada;
    public $cuotasPendientes;
    public $nominaFinPrestamo;
    public $valorCuota;
    public $saldoPrestamo;

    public $totalDeducciones;
    public $totalAPagar;
    public $diasLaborados;
    public $horasNocturnas;
    public $horasExtras;
    public $horasExtrasNocturnas;
    public $horasExtrasDiurnas;

  


    private $db;

    public $salarioMinimo2025 = 1423500; 
    public $auxilioTransporteMensual = 200000; 
   


    public function __construct($empleado) {
        $this->empleado = $empleado;
        // Configuración de la conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
    }

    // Calcular salario según días laborados
    public function calcularSalarioSegunDias($diasLaborados) {
        $salarioMinimo = 1160000; // Salario mínimo mensual en Colombia (2025, ejemplo)
        $this->diasLaborados = $diasLaborados;
        $this->salarioSegunDias = ($salarioMinimo / 30) * $diasLaborados;
        return $this->salarioSegunDias;
    }

    // Calcular auxilio de transporte
    public function calcularAuxTransporte($diasLaborados) {
        $auxTransporte = 140606; // Auxilio de transporte en Colombia (2025, ejemplo)
        $this->auxTransporte = ($auxTransporte / 30) * $diasLaborados;
        return $this->auxTransporte;
    }

    public function calcularSalarioPorEmpleado() {
        $this->salarioSegunDias = ($this->empleado->sueldo / 30) * $this->empleado->diasLaborados;
        return $this->salarioSegunDias;
    }
    
    public function calcularVacacionesDisfrutadas() {
        $diasNoLaborados = 30 - $this->empleado->diasLaborados;
        $this->vacacionesDisfrutadas = ($this->empleado->sueldo / 30) * $diasNoLaborados;
        return $this->vacacionesDisfrutadas;
    }
    public function calcularVacacionesCompensadas($vacacionesCompensadas) {
        $this->vacacionesCompensadas = $vacacionesCompensadas;
        return $this->vacacionesCompensadas;
    }

    public function calcularIncapacidadEmpleador($incapacidadEmpleador) {
        $this->incapacidadEmpleador = $incapacidadEmpleador;
        return $this->incapacidadEmpleador;
    }
    public function calcularIncapacidadEPS($incapacidadEPS) {
        $this->incapacidadEPS = $incapacidadEPS;
        return $this->incapacidadEPS;
    }
    public function calcularIncapacidadARL($incapacidadARL) {
        $this->incapacidadARL = $incapacidadARL;
        return $this->incapacidadARL;
    }

    // Calcular recargo nocturno (35% del valor de la hora)
    public function calcularRecargoNocturno($horasNocturnas) {
        $salarioMinimo = 1160000; // Salario mínimo mensual
        $valorHora = $salarioMinimo / 240; // 240 horas laborales al mes
        $recargo = $valorHora * 0.35; // 35% de recargo nocturno
        $this->recargoNocturno = $recargo * $horasNocturnas;
        return $this->recargoNocturno;
    }

    // Calcular horas extras diurnas (25% adicional)
    public function calcularHorasExtrasDiurnas($horasExtras) {
        $salarioMinimo = 1160000; // Salario mínimo mensual
        $valorHora = $salarioMinimo / 240; // 240 horas laborales al mes
        $extraDiurna = $valorHora * 1.25; // 25% adicional
        $this->extraTurno = $extraDiurna * $horasExtras;
        return $this->extraTurno;
    }

    // Calcular horas extras nocturnas (75% adicional)
    public function calcularHorasExtrasNocturnas($horasExtrasNocturnas) {
        $salarioMinimo = 1160000; // Salario mínimo mensual
        $valorHora = $salarioMinimo / 240; // 240 horas laborales al mes
        $extraNocturna = $valorHora * 1.75; // 75% adicional
        $this->extraTurno = $extraNocturna * $horasExtrasNocturnas;
        return $this->extraTurno;
    }

    // Calcular horas dominicales y festivas (100% adicional)
    public function calcularHorasDominicales($horasDominicales) {
        $salarioMinimo = 1160000; // Salario mínimo mensual
        $valorHora = $salarioMinimo / 240; // 240 horas laborales al mes
        $recargoDominical = $valorHora * 2; // 100% adicional
        $this->horasDominicales = $recargoDominical * $horasDominicales;
        return $this->horasDominicales;
    }

    // Calcular total devengado
    public function calcularTotalDevengado() {
        $this->totalDevengado = $this->salarioSegunDias + $this->auxTransporte + $this->recargoNocturno + $this->extraTurno + $this->horasDominicales;
        return $this->totalDevengado;
    }

    // Calcular deducciones (salud y pensión)
    public function calcularDeducciones() {
        $salud = $this->totalDevengado * 0.04; // 4% para salud
        $pension = $this->totalDevengado * 0.04; // 4% para pensión
        $this->totalDeducciones = $salud + $pension;
        return $this->totalDeducciones;
    }

    // Calcular total a pagar
    public function calcularTotalAPagar() {
        $this->totalAPagar = $this->totalDevengado - $this->totalDeducciones;
        return $this->totalAPagar;
    }

    // Obtener todos los registros de nómina
    public function obtenerNominas() {
        $query = $this->db->prepare("SELECT * FROM nominas");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo registro de nómina
    public function agregarNomina($datos) {
        $query = $this->db->prepare("INSERT INTO nominas (campo1, campo2, campo3) VALUES (:valor1, :valor2, :valor3)");
        $query->bindParam(':valor1', $datos['campo1']);
        $query->bindParam(':valor2', $datos['campo2']);
        $query->bindParam(':valor3', $datos['campo3']);
        $query->execute();
    }

    // Actualizar un registro de nómina existente
    public function actualizarNomina($id, $datosActualizados) {
        $query = $this->db->prepare("UPDATE nominas SET campo1 = :valor1, campo2 = :valor2, campo3 = :valor3 WHERE id = :id");
        $query->bindParam(':valor1', $datosActualizados['campo1']);
        $query->bindParam(':valor2', $datosActualizados['campo2']);
        $query->bindParam(':valor3', $datosActualizados['campo3']);
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Eliminar un registro de nómina
    public function eliminarNomina($id) {
        $query = $this->db->prepare("DELETE FROM nominas WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Otros métodos como agregarNomina, actualizarNomina, eliminarNomina, etc.
}
