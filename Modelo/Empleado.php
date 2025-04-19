<?php
class Empleado{

    private $nombre;
    private $centroCosto;
    private $cargo;
    private $sueldo;
    private $identifiacion;
    private $salarioSegunDias; // Nueva propiedad
    private $diasLaborados;
    private $fecha_Exp;
    private $ciudad_Exp;


    public function __construct()
    {
        $nombre = '';
        $centroCosto = '';
        $cargo = 0;
        $sueldo = '';
        $identifiacion = 0;
        $salarioSegunDias = 0;
        $fecha_exp = '';
        $ciudad_Exp = '';
    }
    
    // Getters
    public function getCiudad_Exp(){ return $this->ciudad_Exp; }
    public function getFecha_Exp(){ return $this->fecha_Exp; }
    public function getNombre(){ return $this->nombre; }
    public function getCentroCosto(){ return $this->centroCosto; }
    public function getCargo(){ return $this->cargo; }
    public function getSueldo(){ return $this->sueldo; }
    public function getIdentifiacion(){ return $this->identifiacion; }
    public function getDiasLaborados(){ return $this->diasLaborados; } // Nuevo getter

    // Setters
    public function setCiudad_Exp($ciudad_Exp){ $this->$ciudad_Exp = $ciudad_Exp; }
    public function setFecha_Exp($fecha_Exp){ $this->$fecha_Exp = $fecha_Exp; }
    public function setNombre($nombre){ $this->nombre = $nombre; }
    public function setCentroCosto($centroCosto){ $this->centroCosto = $centroCosto; }
    public function setCargo($cargo){ $this->cargo = $cargo; }
    public function setSueldo($sueldo){ $this->sueldo = $sueldo; }
    public function setIdentifiacion($identifiacion){ $this->identifiacion = $identifiacion; }
    public function setSalarioSegunDias($diasLaborados){ $this->diaslaborados = $diasLaborados; } // Nuevo setter

    public function __toString(){
        return "Nombre: ".$this->nombre.
               " Centro de Costo: ".$this->centroCosto.
               " Cargo: ".$this->cargo.
               " Sueldo: ".$this->sueldo.
               " Identifiacion: ".$this->identifiacion.
               " Dias laborados: ".$this->diasLaborados;
    }

    public function InsertarEmpleado()
    {
        require_once '../Configuraciones/bd.php';

        $db = new Database();
        $conn = $db->conexion;

        // Preparar la instrucción SQL
        $stmt = $conn->prepare("INSERT INTO Identificacion (ID_Cedula, ID_Tipo, Fecha_Exp, Ciudad_Exp) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $conn->error;
            return;
        }

        // Enlazar parámetros
        $stmt->bind_param("iiss", $identificacion, $tipo, $fecha_Exp, $ciudad_Exp);

        // Ejecutar
        if ($stmt->execute()) {
            echo "Empleado insertado correctamente.";
        } else {
            echo "Error al insertar el empleado: " . $stmt->error;
        }

        // Cerrar conexiones
        $stmt->close();
        $db->cerrarConexion();
    }    
    public function EliminarEmpleado($id)
    {
        require_once '../Configuraciones/bd.php';

        $db = new Database();
        $conn = $db->conexion;

        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            echo "ID inválido.";
            return;
        }

        // Iniciar transacción
        $conn->begin_transaction();

        try {
            // Eliminar de Identificacion
            $stmt3 = $conn->prepare("DELETE FROM Identificacion WHERE ID_Cedula = ?");
            $stmt3->bind_param("i", $id);
            $stmt3->execute();
            $stmt3->close();

            // Eliminar de Persona
            $stmt2 = $conn->prepare("DELETE FROM Persona WHERE ID_Cedula = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $stmt2->close();

            // Eliminar de Empleado
            $stmt1 = $conn->prepare("DELETE FROM Empleado WHERE ID_Persona = ?");
            $stmt1->bind_param("i", $id);
            $stmt1->execute();
            $stmt1->close();

            // Confirmar transacción
            $conn->commit();
            echo "Registro eliminado correctamente.";
        } catch (Exception $e) {
            // Revertir cambios si hay error
            $conn->rollback();
            echo "Error al eliminar el registro: " . $e->getMessage();
        }

        $db->cerrarConexion();
    }

}

?>