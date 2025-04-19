<?php
require_once 'Modelo/Nomina.php';
require_once 'Modelo/procesoNomina.php';

class ControladorNomina {

    private $modelo;
    private $procesoNomina;

    public function __construct($empleado) {
        $this->modelo = new Nomina($empleado);
        $this->procesoNomina = new ProcesoNomina($empleado);
    }

    public function vistaNomina() {
        try {
            $listaNomina = $this->modelo->obtenerNominas();
            include 'Vista/vista_Nomina.php';
        } catch (Exception $e) {
            die("Error al cargar la vista de nómina: " . $e->getMessage());
        }
    }

    public function mostrarFormulario() {
        include 'Vista/crear_Eliminar.php';
    }

    public function crearNomina($datos) {
        try {
            if (isset($datos['campo1'], $datos['campo2'], $datos['campo3'])) {
                $this->modelo->agregarNomina($datos);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("Datos incompletos para crear la nómina.");
            }
        } catch (Exception $e) {
            die("Error al crear la nómina: " . $e->getMessage());
        }
    }

    // Editar nómina
    public function editarNomina($id, $datosActualizados) {
        try {
            if (isset($id, $datosActualizados['campo1'], $datosActualizados['campo2'], $datosActualizados['campo3'])) {
                $this->modelo->actualizarNomina($id, $datosActualizados);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("Datos incompletos para actualizar la nómina.");
            }
        } catch (Exception $e) {
            die("Error al actualizar la nómina: " . $e->getMessage());
        }
    }

    public function eliminarNomina($id) {
        try {
            if (isset($id)) {
                $this->modelo->eliminarNomina($id);
                header("Location: index.php?accion=verNomina");
            } else {
                throw new Exception("ID no proporcionado para eliminar la nómina.");
            }
        } catch (Exception $e) {
            die("Error al eliminar la nómina: " . $e->getMessage());
        }
    }

    // Calcular conceptos adicionales de nómina
    public function calcularConceptos($datos) {
        try {
            // Validar datos necesarios para los cálculos
            if (isset($datos['diasLaborados'], $datos['horasNocturnas'], $datos['horasExtrasDiurnas'], $datos['horasExtrasNocturnas'], $datos['horasDominicales'])) {
                $salario = $this->procesoNomina->calcularSalarioSegunDias($datos['diasLaborados']);
                $auxTransporte = $this->procesoNomina->calcularAuxTransporte($datos['diasLaborados']);
                $recargoNocturno = $this->procesoNomina->calcularRecargoNocturno($datos['horasNocturnas']);
                $horasExtrasDiurnas = $this->procesoNomina->calcularHorasExtrasDiurnas($datos['horasExtrasDiurnas']);
                $horasExtrasNocturnas = $this->procesoNomina->calcularHorasExtrasNocturnas($datos['horasExtrasNocturnas']);
                $horasDominicales = $this->procesoNomina->calcularHorasDominicales($datos['horasDominicales']);
                $vacacionesDisfrutadas = $this->procesoNomina->calcularVacacionesDisfrutadas();
                $vacacionesCompensadas = $this->procesoNomina->calcularVacacionesCompensadas($datos['vacacionesCompensadas']);
                $incapacidadEmpleador = $this->procesoNomina->calcularIncapacidadEmpleador($datos['incapacidadEmpleador']);
                $incapacidadEPS = $this->procesoNomina->calcularIncapacidadEPS($datos['incapacidadEPS']);
                $incapacidadARL = $this->procesoNomina->calcularIncapacidadARL($datos['incapacidadARL']);
                $totalDevengado = $this->procesoNomina->calcularTotalDevengado();
                $deducciones = $this->procesoNomina->calcularDeducciones();
                $totalAPagar = $this->procesoNomina->calcularTotalAPagar();

                // Retornar los resultados como un arreglo asociativo
                return [
                    'salario' => $salario,
                    'auxTransporte' => $auxTransporte,
                    'recargoNocturno' => $recargoNocturno,
                    'horasExtrasDiurnas' => $horasExtrasDiurnas,
                    'horasExtrasNocturnas' => $horasExtrasNocturnas,
                    'horasDominicales' => $horasDominicales,
                    'vacacionesDisfrutadas' => $vacacionesDisfrutadas,
                    'vacacionesCompensadas' => $vacacionesCompensadas,
                    'incapacidadEmpleador' => $incapacidadEmpleador,
                    'incapacidadEPS' => $incapacidadEPS,
                    'incapacidadARL' => $incapacidadARL,
                    'totalDevengado' => $totalDevengado,
                    'deducciones' => $deducciones,
                    'totalAPagar' => $totalAPagar
                ];
            } else {
                throw new Exception("Datos incompletos para realizar los cálculos.");
            }
        } catch (Exception $e) {
            die("Error al calcular los conceptos: " . $e->getMessage());
        }
    }

    // Mostrar resultados de los cálculos
    public function mostrarResultados($datos) {
        try {
            $resultados = $this->calcularConceptos($datos);
            include 'Vista/vista_Resultados.php';
        } catch (Exception $e) {
            die("Error al mostrar los resultados: " . $e->getMessage());
        }
    }
}
