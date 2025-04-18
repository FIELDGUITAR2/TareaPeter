<?php
class Empleado{

    private $nombre;
    private $centroCosto;
    private $cargo;
    private $sueldo;
    private $identifiacion;
    private $salarioSegunDias; // Nueva propiedad


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
    public function getNombre()
    { 
        return $this->nombre; 
    }
    public function getCentroCosto()
    {
         return $this->centroCosto; 
    }
    public function getCargo()
    {
         return $this->cargo; 
    }
    public function getSueldo()
    {
        return $this->sueldo; 
    }
    public function getIdentifiacion()
    { 
        return $this->identifiacion; 
    }
    public function getSalarioSegunDias()
    { 
        return $this->salarioSegunDias; 
    } // Nuevo getter

    // Setters
    public function setNombre($nombre)
    { 
        $this->nombre = $nombre; 
    }
    public function setCentroCosto($centroCosto)
    { 
        $this->centroCosto = $centroCosto; 
    }
    public function setCargo($cargo)
    { 
        $this->cargo = $cargo; 
    }
    public function setSueldo($sueldo)
    { 
        $this->sueldo = $sueldo; 
    }
    public function setIdentifiacion($identifiacion)
    { 
        $this->identifiacion = $identifiacion; 
    }
    public function setSalarioSegunDias($salarioSegunDias)
    { 
        $this->salarioSegunDias = $salarioSegunDias; 
    } // Nuevo setter

    public function EliminarEmpleado()
    {


    }
    public function AgregarEmpleado()
    {


    }
}

?>