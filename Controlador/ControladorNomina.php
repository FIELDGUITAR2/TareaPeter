<?php
require_once 'Modelo/Nomina.php';

class ControladorNomina {

    private $modelo;

    public function __construct($empleado) {
        // Pasar el objeto empleado al modelo
        $this->modelo = new Nomina($empleado);
    }

    // Mostrar todos los registros de nómina
    public function vistaNomina() {
        try {
            $listaNomina = $this->modelo->obtenerNominas();
            include 'Vista/vista_Nomina.php';
        } catch (Exception $e) {
            die("Error al cargar la vista de nómina: " . $e->getMessage());
        }
    }

    // Mostrar formulario de creación (si es por separado)
    public function mostrarFormulario() {
        include 'Vista/crear_Eliminar.php';
    }

    // Guardar o crear nuevo registro de nómina
    public function crearNomina($datos) {
        try {
            // Validar datos antes de enviarlos al modelo
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

    // Editar nómina (si implementas edición)
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

    // Eliminar una nómina
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

    // Calcular total devengado, deducciones y total a pagar
    public function calcularTotales($datos) {
        try {
            // Validar datos necesarios para los cálculos
            if (isset($datos['diasLaborados'], $datos['horasNocturnas'], $datos['horasExtrasDiurnas'], $datos['horasExtrasNocturnas'], $datos['horasDominicales'])) {
                $salario = $this->modelo->calcularSalarioSegunDias($datos['diasLaborados']);
                $auxTransporte = $this->modelo->calcularAuxTransporte($datos['diasLaborados']);
                $recargoNocturno = $this->modelo->calcularRecargoNocturno($datos['horasNocturnas']);
                $horasExtrasDiurnas = $this->modelo->calcularHorasExtrasDiurnas($datos['horasExtrasDiurnas']);
                $horasExtrasNocturnas = $this->modelo->calcularHorasExtrasNocturnas($datos['horasExtrasNocturnas']);
                $horasDominicales = $this->modelo->calcularHorasDominicales($datos['horasDominicales']);
                $totalDevengado = $this->modelo->calcularTotalDevengado();
                $deducciones = $this->modelo->calcularDeducciones();
                $totalAPagar = $this->modelo->calcularTotalAPagar();

                // Retornar los resultados como un arreglo asociativo
                return [
                    'salario' => $salario,
                    'auxTransporte' => $auxTransporte,
                    'recargoNocturno' => $recargoNocturno,
                    'horasExtrasDiurnas' => $horasExtrasDiurnas,
                    'horasExtrasNocturnas' => $horasExtrasNocturnas,
                    'horasDominicales' => $horasDominicales,
                    'totalDevengado' => $totalDevengado,
                    'deducciones' => $deducciones,
                    'totalAPagar' => $totalAPagar
                ];
            } else {
                throw new Exception("Datos incompletos para realizar los cálculos.");
            }
        } catch (Exception $e) {
            die("Error al calcular los totales: " . $e->getMessage());
        }
    }

    // Mostrar resultados de los cálculos
    public function mostrarResultados($datos) {
        try {
            $resultados = $this->calcularTotales($datos);
            include 'Vista/vista_Resultados.php';
        } catch (Exception $e) {
            die("Error al mostrar los resultados: " . $e->getMessage());
        }
    }
}
