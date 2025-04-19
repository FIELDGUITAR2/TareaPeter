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

    public function InsetarEmpleado()
    {
        require_once '../Configuraciones/bd.php';

        $db = new Database();
        $instruccion = "Insert into Identificacion(ID_Cedula,ID_Tipo,Fecha_Exp,Ciudad_Exp) values (" . $identificacion . "," . $fecha_Exp . "," . $ciudad_Exp . ";";
        $resultado = $db->conexion->query($instruccion);

        /*while ($fila = $resultado->fetch_assoc()) {
            echo '<td>';
            echo $fila['nombre'];//falta esta parte
            echo $fila[]

            echo '</td>';
        }*/
        $db->cerrarConexion();
    }
}

?>