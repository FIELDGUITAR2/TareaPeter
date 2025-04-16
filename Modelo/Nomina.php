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

    public function __construct($empleado) {
        $this->empleado = $empleado;
        // Configuración de la conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
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
    
}