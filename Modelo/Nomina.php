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

    public $salarioMinimo2025 = 1423500; 
    public $auxilioTransporteMensual = 200000; 
   

    public function __construct($empleado) {
        $this->empleado = $empleado;
    }
    public function calcularSalarioSegunDias() {
        $this->salarioSegunDias = ($this->empleado->sueldo / 30) * $this->empleado->diasLaborados;
        return $this->salarioSegunDias;
    }
    
    public function calcularVacacionesDisfrutadas() {
        $diasNoLaborados = 30 - $this->empelado->diasLaborados;
        $this->vacacionesDisfrutadas = ($this->empleado->sueldo / 30) * $diasNoLaborados;
        return $this->vacacionesDisfrutadas;
    }
    public function calcularVacacionesCompensadas($vacacionesCompensadas) {
        $this->vacacionesCompensadas = $vacacionesCompensadas;
        return $this->vacacionesCompensadas;
    }
    public function calcularAuxTransporte($diasLaborados) {
        if ($this->empleado->sueldo <= 2 * $this->salarioMinimo2025) {
            $this->auxTransporte = ($this->auxilioTransporteMensual / 30) * $diasLaborados;
        } else {
            $this->auxTransporte = 0;
        }
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
    public function calcularAuxAlimentacionNopre($auxAlimentacion){
        $this->auxAlimentacion = $auxAlimentacion;
        return $this->auxAlimentacion;
    }
    public function calcularTotalDevengado() {
        $this->totalDevengado =
            $this->salarioSegunDias +
            $this->vacacionesDisfrutadas +
            $this->vacacionesCompensadas +
            $this->auxTransporte +
            $this->incapacidadEmpleador +
            $this->incapacidadEPS +
            $this->incapacidadARL +
            $this->extraTurno +
            $this->recargoNocturno +
            $this->horasDominicales +
            $this->auxAlimentacion;
    
        return $this->totalDevengado;
    }
    public function calcularDeduccionesSalud() {
        $this->salud = ($this->empleado->sueldo+ $this->vacacionesCompensadas + $this->extraTurno )* 0.04;
        return $this->salud;
    }
    public function calcularDeduccionesPension() {
        $this->pension = ($this->empleado->sueldo+ $this->vacacionesCompensadas + $this->extraTurno )* 0.04;
        return $this->pension;
    }
    public function calcularFondoSolidaridadPensional() {
        if ($this->empleado->sueldo > 4000000) {
            $this->fondoSolidaridad = $this->empleado->sueldo * 0.01;  
        } else {
            $this->fondoSolidaridad = 0;
        }
        return $this->fondoSolidaridad;  
    }
    
    
    
    
}