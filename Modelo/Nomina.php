<?php
class Nomina {
    private $empleado;
    private $devengado;
    private $deduccion;
    private $totalAPagar;

    public function __construct(
        $empleado,
        $diasLaborados,
        $salarioSegunDias,
        $vacacionesDisfrutadas,
        $vacacionesCompensadas,
        $auxilioTransporte,
        $auxilioIncapacidadEmpleador,
        $pagoIncapacidadEPS,
        $pagoIncapacidadARL,
        $extraTurno,
        $recargoNocturno,
        $horasDominicales,
        $auxAlimentacionNoPrestacional
    ) {
        $this->empleado = $empleado;
        $this->devengado = new procesoDevengados(
            $empleado,
            $diasLaborados,
            $salarioSegunDias,
            $vacacionesDisfrutadas,
            $vacacionesCompensadas,
            $auxilioTransporte,
            $auxilioIncapacidadEmpleador,
            $pagoIncapacidadEPS,
            $pagoIncapacidadARL,
            $extraTurno,
            $recargoNocturno,
            $horasDominicales,
            $auxAlimentacionNoPrestacional
        );
    }

    public function procesarDevengados($datosHorasExtras) {
        $this->devengado->calcularSalarioPorEmpleado();
        $this->devengado->calcularAuxTransporte();
        $this->devengado->calcularRecargoNocturno($datosHorasExtras['horasNocturnas']);
        $this->devengado->calcularHorasExtrasDiurnas($datosHorasExtras['horasExtrasDiurnas']);
        $this->devengado->calcularHorasExtrasNocturnas($datosHorasExtras['horasExtrasNocturnas']);
        $this->devengado->calcularHorasDominicales($datosHorasExtras['horasDominicales']);
        $this->devengado->calcularVacacionesDisfrutadas();
        $this->devengado->calcularVacacionesCompensadas($datosHorasExtras['vacacionesCompensadas']);
        $this->devengado->calcularIncapacidadEmpleador($datosHorasExtras['incapacidadEmpleador']);
        $this->devengado->calcularIncapacidadEPS($datosHorasExtras['incapacidadEPS']);
        $this->devengado->calcularIncapacidadARL($datosHorasExtras['incapacidadARL']);
    }

    public function procesarDeducciones($salarioBase, $anticiposNomina, $pagoVacaciones, $diasVacaciones, $fondoSolidaridad = 0, $prestamo = []) {
        // Crear instancia de procesoDeducciones
        $this->deduccion = new procesoDeducciones(
            0, // Salud (se calculará más adelante)
            0, // Pensión (se calculará más adelante)
            $fondoSolidaridad,
            $anticiposNomina,
            $pagoVacaciones,
            $prestamo['monto'] ?? 0,
            $prestamo['cuotas'] ?? 0,
            $prestamo['cuotasPagadas'] ?? 0,
            $prestamo['valorCuota'] ?? 0,
            $salarioBase
        );

        // Calcular deducciones específicas
        $salud = $this->deduccion->calcularSalud();
        $pension = $this->deduccion->calcularPension();
        $fondoSolidaridad = $this->deduccion->calcularFondoSolidaridad();
        $vacaciones = $this->deduccion->calcularPagoVacaciones($diasVacaciones);

        // Sumar todas las deducciones
        $this->deduccion->salud = $salud['empleado']; // Solo el aporte del empleado
        $this->deduccion->pension = $pension['empleado']; // Solo el aporte del empleado
        $this->deduccion->fondoSolidaridad = $fondoSolidaridad;
        $this->deduccion->pagoVacaciones = $vacaciones;

        return $this->deduccion->getTotalDeducciones();
    }

    public function calcularTotalAPagar() {
        $this->totalAPagar = $this->devengado->getTotalDevengado() - $this->deduccion->getTotalDeducciones();
        return $this->totalAPagar;
    }

    public function getResumenNomina() {
        return [
            'empleado' => $this->empleado,
            'devengado' => $this->devengado->getTotalDevengado(),
            'deduccion' => $this->deduccion->getTotalDeducciones(),
            'totalAPagar' => $this->totalAPagar
        ];
    }
}
?>
