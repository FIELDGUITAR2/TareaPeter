<?php
class Empleado{

    private $nombre;
    private $centroCosto;
    private $cargo;
    private $sueldo;
    private $identifiacion;
    private $salarioSegunDias; // Nueva propiedad
    private $diasLaborados;


    public function __construct()
    {
        $nombre = '';
        $centroCosto = '';
        $cargo = 0;
        $sueldo = '';
        $identifiacion = 0;
        $salarioSegunDias = 0;
    }
    
    // Getters
    public function getNombre(){ return $this->nombre; }
    public function getCentroCosto(){ return $this->centroCosto; }
    public function getCargo(){ return $this->cargo; }
    public function getSueldo(){ return $this->sueldo; }
    public function getIdentifiacion(){ return $this->identifiacion; }
    public function getDiasLaborados(){ return $this->diasLaborados; } // Nuevo getter

    // Setters
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

    public function InsetarEmpleado()
    {
        require_once '../Configuraciones/bd.php';

        $db = new Database();

        $resultado = $db->conexion->query("Insert into ");

        while ($fila = $resultado->fetch_assoc()) {
            echo $fila['nombre'] . "<br>";
        }

        $db->cerrarConexion();
    }
}

?>