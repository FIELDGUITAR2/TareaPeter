<?php
require_once 'Empleado.php';
require_once 'Nomina.php';

class ControladorEmpleado {
    private $pdo;

    public function __construct() {
        $db = new Database(); 
        $this->conexion = $db->conexion; 
    }

    public function mostrarEmpleados() {
        $stmt = $this->pdo->query("SELECT e.*, n.fecha_nomina 
                                  FROM empleados e 
                                  LEFT JOIN nominas n ON e.nomina_id = n.id");
        $empleados = $stmt->fetchAll(PDO::FETCH_CLASS, 'Empleado');
        include 'vista_Empleado.php';
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM empleados WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Empleado');
        return $stmt->fetch();
    }

    public function crearEmpleado($datos, $nominaId = null) {
        $empleado = new Empleado(
            $datos['nombre'],
            $datos['apellido'],
            $datos['centro_costo'],
            $datos['cargo'],
            $datos['sueldo'],
            $datos['identificacion'],
            $datos['dias_laborados'] ?? 0,
            $datos['salario_base'] ?? 0,
            $datos['tipo_contrato'] ?? '',
            isset($datos['tiene_aux_transporte']),
            $datos['aux_alimentacion'] ?? 0,
            $nominaId
        );
        $empleado->guardar();
        return $empleado;
    }

    public function asignarNomina($empleadoId, $nominaId) {
        $stmt = $this->pdo->prepare("UPDATE empleados SET nomina_id = ? WHERE id = ?");
        return $stmt->execute([$nominaId, $empleadoId]);
    }

    public function eliminarEmpleado($id) {
        $stmt = $this->pdo->prepare("DELETE FROM empleados WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerEmpleadosPorNomina($nominaId) {
        $stmt = $this->pdo->prepare("SELECT * FROM empleados WHERE nomina_id = ?");
        $stmt->execute([$nominaId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }
}