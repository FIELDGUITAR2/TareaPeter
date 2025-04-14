<?php
class Nomina {
    public $empleado; // objeto de la clase Empleado
    public $diasLaborados;
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

    public function __construct($empleado) {
        $this->empleado = $empleado;
    }
    public function calcularSalarioSegunDias($diasLaborados) {
        $this->diasLaborados = $diasLaborados;
        $this->salarioSegunDias = ($this->empleado->sueldo / 30) * $diasLaborados;
        return $this->salarioSegunDias;
    }
    public function calcularVacacionesDisfrutadas($vacacionesDisfrutadas) {
        $this->vacacionesDisfrutadas = $vacacionesDisfrutadas;
        return $this->vacacionesDisfrutadas;
    }
    public function calcularVacacionesCompensadas($vacacionesCompensadas) {
        $this->vacacionesCompensadas = $vacacionesCompensadas;
        return $this->vacacionesCompensadas;
    }
    public function calcularAuxTransporte($auxTransporte) {
        $this->auxTransporte = $auxTransporte;
        return $this->auxTransporte;
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
    public function calcularExtraTurno($extraTurno) {
        $this->extraTurno = $extraTurno;
        return $this->extraTurno;
    }
    public function calcularRecargoNocturno($recargoNocturno) {
        $this->recargoNocturno = $recargoNocturno;
        return $this->recargoNocturno;
    }
    public function calcularHorasDominicales($horasDominicales) {
        $this->horasDominicales = $horasDominicales;
        return $this->horasDominicales;
    }
    
}