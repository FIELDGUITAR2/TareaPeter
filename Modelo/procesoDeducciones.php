<?php
class procesoDeducciones {
    private $salud;
    private $pension;
    private $fondoSolidaridad;
    private $anticiposNomina;
    private $pagoVacaciones;
    private $montoDesembolso;
    private $cuotasDescontar;
    private $cuotaPagada;
    private $valorCuota;
    private $salarioBase;

    public function __construct(
        $salud, $pension, $fondoSolidaridad, $anticiposNomina, $pagoVacaciones,
        $montoDesembolso, $cuotasDescontar, $cuotaPagada, $valorCuota, $salarioBase
    ) {
        $this->salud = $salud;
        $this->pension = $pension;
        $this->fondoSolidaridad = $fondoSolidaridad;
        $this->anticiposNomina = $anticiposNomina;
        $this->pagoVacaciones = $pagoVacaciones;
        $this->montoDesembolso = $montoDesembolso;
        $this->cuotasDescontar = $cuotasDescontar;
        $this->cuotaPagada = $cuotaPagada;
        $this->valorCuota = $valorCuota;
        $this->salarioBase = $salarioBase;
    }

    public function getTotalDeducciones() {
        return $this->salud + $this->pension + $this->fondoSolidaridad +
               $this->anticiposNomina + $this->pagoVacaciones +
               ($this->cuotaPagada * $this->valorCuota);
    }

    // Calcular aporte a salud
    public function calcularSalud() {
        $aporteEmpleado = $this->salarioBase * 0.04; // 4% del empleado
        $aporteEmpleador = $this->salarioBase * 0.085; // 8.5% del empleador
        return [
            'empleado' => $aporteEmpleado,
            'empleador' => $aporteEmpleador,
            'total' => $aporteEmpleado + $aporteEmpleador
        ];
    }

    // Calcular aporte a pensión
    public function calcularPension() {
        $aporteEmpleado = $this->salarioBase * 0.04; // 4% del empleado
        $aporteEmpleador = $this->salarioBase * 0.12; // 12% del empleador
        return [
            'empleado' => $aporteEmpleado,
            'empleador' => $aporteEmpleador,
            'total' => $aporteEmpleado + $aporteEmpleador
        ];
    }

    // Calcular fondo de solidaridad pensional
    public function calcularFondoSolidaridad() {
        $salarioMinimo = 1160000; // Salario mínimo en Colombia (2025, ejemplo)
        if ($this->salarioBase > 4 * $salarioMinimo) {
            return $this->salarioBase * 0.01; // 1% del salario base
        }
        return 0; // No aplica si el salario es menor o igual a 4 SMLMV
    }

    // Calcular pago de vacaciones
    public function calcularPagoVacaciones($diasVacaciones) {
        $valorDia = $this->salarioBase / 30; // Valor diario del salario
        return $valorDia * $diasVacaciones;
    }
}
?>
