<?php
require_once 'Empleado.php';

class ControladorEmpleado {
    public function mostrarEmpleados() {
        $empleados = Empleado::obtenerTodos();
        include 'vista_Empleado.php';
    }

    public function crearEmpleado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extraer datos del formulario
            $empleado = new Empleado(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['centro_costo'],
                $_POST['cargo'],
                $_POST['sueldo'],
                $_POST['identificacion'],
                $_POST['dias_laborados'] ?? 0,
                $_POST['salario_base'] ?? 0,
                $_POST['tipo_contrato'] ?? '',
                isset($_POST['tiene_aux_transporte']),
                $_POST['aux_alimentacion'] ?? 0
            );
            $empleado->guardar();
            header('Location: index.php?accion=empleados');
        } else {
            include 'vista_crear_Empleado.php';
        }
    }

    public function eliminarEmpleado($id) {
        Empleado::eliminar($id);
        header('Location: index.php?accion=empleados');
    }
    
    public function crearNomina() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Obtener empleado
            $empleado = Empleado::obtenerPorId($_POST['empleado_id']);
            
            // 2. Crear nómina
            $nomina = new Nomina($empleado, $_POST['fecha_nomina']);
            
            // 3. Agregar devengados
            $nomina->agregarDevengado('Salario básico', $_POST['salario']);
            $nomina->agregarDevengado('Horas extras', $_POST['horas_extras']);
            $nomina->agregarDevengado('Auxilio transporte', $_POST['aux_transporte']);
            
            // 4. Agregar deducciones
            $nomina->agregarDeduccion('Salud', $_POST['salud']);
            $nomina->agregarDeduccion('Pensión', $_POST['pension']);
            
            // 5. Guardar en base de datos
            $this->guardarNominaEnBD($nomina);
            
            header('Location: ver_nomina.php?id=' . $nomina->getId());
        } else {
            $empleados = Empleado::obtenerTodos();
            include 'vista_crear_nomina.php';
        }
    }

    private function guardarNominaEnBD(Nomina $nomina) {
        $pdo = new PDO(...);
        $stmt = $pdo->prepare("INSERT INTO nominas 
            (empleado_id, fecha, devengados, deducciones) 
            VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $nomina->getEmpleado()->getId(),
            $nomina->getFecha(),
            json_encode($nomina->getDevengados()),
            json_encode($nomina->getDeducciones())
        ]);
        $nomina->setId($pdo->lastInsertId());
    }

}