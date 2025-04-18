<?php
class Nomina {
    private $empleado; // objeto de la clase Empleado
    private $vacacionesDisfrutadas;
    private $vacacionesCompensadas;
    private $auxTransporte;
    private $incapacidadEmpleador;
    private $incapacidadEPS;
    private $incapacidadARL;
    private $extraTurno;
    private $recargoNocturno;
    private $horasDominicales;
    private $auxAlimentacion;
    private $totalDevengado;
    private $salud;
    private $pension;
    private $fondoSolidaridad;
    private $anticiposNomina;
    private $pagoVacaciones;
    private $prestamoMonto;
    private $cuotasDescontar;
    private $fechaDesembolso;
    private $cuotaPagada;
    private $cuotasPendientes;
    private $nominaFinPrestamo;
    private $valorCuota;
    private $saldoPrestamo;
    private $totalDeducciones;
    private $totalAPagar;
    private $diasLaborados;
    private $horasNocturnas;
    private $horasExtras;
    private $horasExtrasNocturnas;
    private $horasExtrasDiurnas;
    private $salarioSegunDias;
    private $db;
    private $salarioMinimo2025; 
    private $auxilioTransporteMensual = 200000; 
   
    public function __construct($empleado) {
        $this->empleado = $empleado;
        try {
        $this->db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Error en la conexión a la base de datos: " . $e->getMessage());
                }
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


            public function calcularRecargoNocturno($horasNocturnas) {
                $salarioMinimo2025 = 1423500; 
                $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
                $recargo = $valorHora * 0.35; // 35% de recargo nocturno
                $this->recargoNocturno = $recargo * $horasNocturnas;
                return $this->recargoNocturno;
            }

            // Calcular horas extras diurnas (25% adicional)
            public function calcularHorasExtrasDiurnas($horasExtras) {
                $salarioMinimo2025 = 1423500;
                $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
                $extraDiurna = $valorHora * 1.25; // 25% adicional
                $this->extraTurno = $extraDiurna * $horasExtras;
                return $this->extraTurno;
            }

            public function calcularHorasExtrasNocturnas($horasExtrasNocturnas) {
                $salarioMinimo2025 = 1423500;
                $valorHora = $salarioMinimo2025 / 240; // 240 horas laborales al mes
                $extraNocturna = $valorHora * 1.75; // 75% adicional
                $this->extraTurno = $extraNocturna * $horasExtrasNocturnas;
                return $this->extraTurno;
            }

            // Calcular horas dominicales y festivas (100% adicional)
            public function calcularHorasDominicales($horasDominicales) {
                $salarioMinimo2025 = 1423500;
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

            public function calcularTotalAPagar() {
                $this->totalAPagar = $this->totalDevengado - $this->totalDeducciones;
                return $this->totalAPagar;
            }

            // Obtener todos los registros de nómina
            public function obtenerNominas() {
        try {
                $query = $this->db->prepare("SELECT * FROM nominas");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) 
        {
            die("Error al obtener las nóminas: " . $e->getMessage());
        }
    }

    // Agregar un nuevo registro de nómina
    public function agregarNomina($datos) {
try {
        $query = $this->db->prepare("INSERT INTO nominas (campo1, campo2, campo3) VALUES (:valor1, :valor2, :valor3)");
        $query->bindParam(':valor1', $datos['campo1']);
        $query->bindParam(':valor2', $datos['campo2']);
        $query->bindParam(':valor3', $datos['campo3']);
        $query->execute();
} catch (PDOException $e) {
            die("Error al agregar la nómina: " . $e->getMessage());
        }
    }

    // Actualizar un registro de nómina existente
    public function actualizarNomina($id, $datosActualizados) {
try {
        $query = $this->db->prepare("UPDATE nominas SET campo1 = :valor1, campo2 = :valor2, campo3 = :valor3 WHERE id = :id");
        $query->bindParam(':valor1', $datosActualizados['campo1']);
        $query->bindParam(':valor2', $datosActualizados['campo2']);
        $query->bindParam(':valor3', $datosActualizados['campo3']);
        $query->bindParam(':id', $id);
        $query->execute();
} catch (PDOException $e) {
            die("Error al actualizar la nómina: " . $e->getMessage());
        }
    }

    // Eliminar un registro de nómina
    public function eliminarNomina($id) {
try {
        $query = $this->db->prepare("DELETE FROM nominas WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
} catch (PDOException $e) {
            die("Error al eliminar la nómina: " . $e->getMessage());
        }
    }
}
?>