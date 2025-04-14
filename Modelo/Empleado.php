<?php
class Empleado{
    public $nombre;
    public $centroCosto;
    public $cargo;
    public $sueldo;
    public $identifiacion;

    public function __construct($nombre, $centroCosto, $cargo, $sueldo, $identifiacion){
        $this->nombre = $nombre;
        $this->centroCosto = $centroCosto;
        $this->cargo = $cargo;
        $this->sueldo = $sueldo;
        $this->identifiacion = $identifiacion;
    }
    public function getNombre(){
        return $this->nombre;
    }

    public function getCentroCosto(){
        return $this->centroCosto;
    }
    public function getCargo(){
        return $this->cargo;
    }
    public function getSueldo(){
        return $this->sueldo;
    }
    public function getIdentifiacion(){
        return $this->identifiacion;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setCentroCosto($centroCosto){
        $this->centroCosto = $centroCosto;
    }
    public function setCargo($cargo){
        $this->cargo = $cargo;
    }

    public function setSueldo($sueldo){
        $this->sueldo = $sueldo;
    }

    public function setIdentifiacion($identifiacion){
        $this->identifiacion = $identifiacion;
    }
    public function __toString(){
        return "Nombre: ".$this->nombre." Centro de Costo: ".$this->centroCosto." Cargo: ".$this->cargo." Sueldo: ".$this->sueldo." Identifiacion: ".$this->identifiacion;
    }


}
// Compare this snippet from Controlador/ControladorEmpleado.php: