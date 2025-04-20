<?php
require_once 'Modelo/Empleado.php';
require_once 'Modelo/procesoNomina.php';

class ProcesoNomina {

    private $empleado;
    private $extraTurno;
    private $horasDominicales;
    private $totalDevengado;
    private $salud;
    private $pension;
    private $totalDeducciones;
    private $totalAPagar;
    private $salarioSegunDias;
    public $auxTransporte;
    private $diasLaborados; // Días laborados por el empleado
    private $salarioMinimo2025 = 1423500; // Salario mínimo del año 2025;
    private $auxilioTransporteMensual = 200000; // Auxilio de transporte mensual;
    private $vacacionesDisfrutadas; // Valor de las vacaciones disfrutadas;
    private $vacacionesCompensadas; // Valor de las vacaciones compensadas
    private $incapacidadEmpleador; // Valor de la incapacidad asumida por el empleador
    private $incapacidadEPS; // Valor de la incapacidad asumida por la EPS
    private $incapacidadARL; // Valor de la incapacidad asumida por la ARL
    private $recargoNocturno; // Valor del recargo nocturno

    public function __construct($empleado) {
        $this->empleado = $empleado;
        
    }


    // Calcular recargo nocturno (35% adicional)
    public function calcularRecargoNocturno($horasNocturnas) {

        $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
        $recargo = $valorHora * 0.35; // 35% de recargo nocturno
        $this->recargoNocturno = $recargo * $horasNocturnas;
        return $this->recargoNocturno;
    }

    // Calcular horas extras diurnas (25% adicional)
    public function calcularHorasExtrasDiurnas($horasExtras) {

        $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
        $extraDiurna = $valorHora * 1.25; // 25% adicional
        $this->extraTurno = $extraDiurna * $horasExtras;
        return $this->extraTurno;
    }

    // Calcular horas extras nocturnas (75% adicional)
    public function calcularHorasExtrasNocturnas($horasExtrasNocturnas) {

        $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
        $extraNocturna = $valorHora * 1.75; // 75% adicional
        $this->extraTurno = $extraNocturna * $horasExtrasNocturnas;
        return $this->extraTurno;
    }

    // Calcular horas dominicales y festivas (100% adicional)
    public function calcularHorasDominicales($horasDominicales) {

        $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
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
        $salud = $this->totalDevengado * 0.04; 
        $pension = $this->totalDevengado * 0.04;
        $this->totalDeducciones = $salud + $pension;
        return $this->totalDeducciones;
    }

    // Calcular total a pagar
    public function calcularTotalAPagar() {
        $this->totalAPagar = $this->totalDevengado - $this->totalDeducciones;
        return $this->totalAPagar;
    }

    // Calcular salario según días laborados
    public function calcularSalarioSegunDias($diasLaborados) {
        $this->diasLaborados = $diasLaborados;
        $this->salarioSegunDias = ($this->salarioMinimo2025 / 30) * $diasLaborados;
        return $this->salarioSegunDias;
    }

    // Calcular auxilio de transporte
    public function calcularAuxTransporte($diasLaborados) {
        $this->auxTransporte = ($this->auxilioTransporteMensual / 30) * $diasLaborados;
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
}