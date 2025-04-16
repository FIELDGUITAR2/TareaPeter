<?php
require_once 'Modelo/Nomina.php';

class ControladorNomina {

    private $modelo;

    public function __construct() {
        $this->modelo = new Nomina();
    }

    // Mostrar todos los registros de nómina
    public function vistaNomina() {
        $listaNomina = $this->modelo->obtenerNominas();
        include 'Vista/vista_Nomina.php';
    }

    // Mostrar formulario de creación (si es por separado)
    public function mostrarFormulario() {
        include 'Vista/crear_Eliminar.php';
    }

    // Guardar o crear nuevo registro de nómina
    public function crearNomina($datos) {
        $this->modelo->agregarNomina($datos);
        header("Location: index.php?accion=verNomina");
    }

    // Editar nómina (si implementas edición)
    public function editarNomina($id, $datosActualizados) {
        $this->modelo->actualizarNomina($id, $datosActualizados);
        header("Location: index.php?accion=verNomina");
    }

    // Eliminar una nómina
    public function eliminarNomina($id) {
        $this->modelo->eliminarNomina($id);
        header("Location: index.php?accion=verNomina");
    }

    // Calcular total devengado, deducciones y total a pagar
    public function calcularTotales($datos) {
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
    }

    // Mostrar resultados de los cálculos
    public function mostrarResultados($datos) {
        $resultados = $this->calcularTotales($datos);
        include 'Vista/vista_Resultados.php';
    }
}
