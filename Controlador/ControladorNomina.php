<?php
require_once 'Modelo/Nomina.php';
require_once 'Modelo/Empleado.php';

class ControladorNomina {
    public function mostrarNomina() {
        $nominas = Nomina::obtenerTodas();
        include 'Vista/vista_Nomina.php';
    }

    public function generarNomina() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleado = Empleado::obtenerPorId($_POST['id_empleado']);
            $nomina = new Nomina($empleado, $_POST);
            $nomina->calcular();
            $nomina->guardar();
            header('Location: index.php?accion=nomina');
        }
    }
}
