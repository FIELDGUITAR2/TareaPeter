<?php
require_once 'app/modelo/Empleado.php';
require_once 'lib/fpdf/fpdf.php';
require_once 'Modelo/Empleado.php';

$empleados = Empleado::obtenerTodos();
include 'Vista/vista_Empleado.php';


    class ControladorEmpleado {
        public function mostrarEmpleados() {
            $empleados = Empleado::obtenerTodos();
            include 'Vista/vista_Empleado.php';
        }
    
        public function crearEmpleado() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $empleado = new Empleado($_POST);
                $empleado->guardar();
                header('Location: index.php?accion=empleados');
            } else {
                include 'Vista/crear_Eliminar.php';
            }
        }
    
        public function eliminarEmpleado($id) {
            Empleado::eliminar($id);
            header('Location: index.php?accion=empleados');
        }
    }
    