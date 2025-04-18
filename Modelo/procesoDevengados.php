<?php
class procesoDevengados {
    private $diasLaborados;
    private $salarioSegunDias;
    private $vacacionesDisfrutadas;
    private $vacacionesCompensadas;
    private $auxilioTransporte;
    private $auxilioIncapacidadEmpleador;
    private $pagoIncapacidadEPS;
    private $pagoIncapacidadARL;
    private $extraTurno;
    private $recargoNocturno;
    private $horasDominicales;
    private $auxAlimentacionNoPrestacional;
    private $empleado;
    private $salarioMinimo2025 = 1300000; // Salario mínimo para el año 2025
    private $auxilioTransporteMensual = 200000; // Auxilio de transporte mensual
    private $auxTransporte;
    private $incapacidadEmpleador;
    private $incapacidadEPS;
    private $incapacidadARL;


    public function __construct(
        $diasLaborados, $salarioSegunDias, $vacacionesDisfrutadas, $vacacionesCompensadas,
        $auxilioTransporte, $auxilioIncapacidadEmpleador, $pagoIncapacidadEPS, $pagoIncapacidadARL,
        $extraTurno, $recargoNocturno, $horasDominicales, $auxAlimentacionNoPrestacional
    ) {
        $this->diasLaborados = $diasLaborados;
        $this->salarioSegunDias = $salarioSegunDias;
        $this->vacacionesDisfrutadas = $vacacionesDisfrutadas;
        $this->vacacionesCompensadas = $vacacionesCompensadas;
        $this->auxilioTransporte = $auxilioTransporte;
        $this->auxilioIncapacidadEmpleador = $auxilioIncapacidadEmpleador;
        $this->pagoIncapacidadEPS = $pagoIncapacidadEPS;
        $this->pagoIncapacidadARL = $pagoIncapacidadARL;
        $this->extraTurno = $extraTurno;
        $this->recargoNocturno = $recargoNocturno;
        $this->horasDominicales = $horasDominicales;
        $this->auxAlimentacionNoPrestacional = $auxAlimentacionNoPrestacional;
    }

    // Aquí puedes agregar getters para cada atributo si los necesitas
    public function getTotalDevengado() {
        return $this->salarioSegunDias + $this->vacacionesDisfrutadas + $this->vacacionesCompensadas +
               $this->auxilioTransporte + $this->auxilioIncapacidadEmpleador + $this->pagoIncapacidadEPS +
               $this->pagoIncapacidadARL + $this->extraTurno + $this->recargoNocturno +
               $this->horasDominicales + $this->auxAlimentacionNoPrestacional;
    }

    public function calcularSalarioPorEmpleado() {
        $this->salarioSegunDias = ($this->empleado->sueldo / 30) * $this->empleado->diasLaborados;
        return $this->salarioSegunDias;
    }

    public function calcularAuxTransporte() {
        $this->auxTransporte = ($this->auxilioTransporteMensual / 30) * $this->empleado->diasLaborados;
        return $this->auxTransporte;
    }

    public function calcularRecargoNocturno($horasNocturnas) {
        $valorHora = $this->salarioMinimo2025 / 240;
        $recargo = $valorHora * 0.35;
        $this->recargoNocturno = $recargo * $horasNocturnas;
        return $this->recargoNocturno;
    }

    public function calcularHorasExtrasDiurnas($horasExtras) {
        $valorHora = $this->salarioMinimo2025 / 240;
        $extraDiurna = $valorHora * 1.25;
        $this->extraTurno += $extraDiurna * $horasExtras;
        return $this->extraTurno;
    }

    public function calcularHorasExtrasNocturnas($horasExtrasNocturnas) {
        $valorHora = $this->salarioMinimo2025 / 240;
        $extraNocturna = $valorHora * 1.75;
        $this->extraTurno += $extraNocturna * $horasExtrasNocturnas;
        return $this->extraTurno;
    }

    public function calcularHorasDominicales($horasDominicales) {
        $valorHora = $this->salarioMinimo2025 / 240;
        $recargoDominical = $valorHora * 2;
        $this->horasDominicales = $recargoDominical * $horasDominicales;
        return $this->horasDominicales;
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


?>
