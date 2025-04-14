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
}