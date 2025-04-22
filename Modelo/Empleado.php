<?php
class Empleado{
    private $nombre;
    private $centroCosto;
    private $cargo;
    private $sueldo;
    private $identifiacion;
    private $diasLaborados;

    public function __construct($nombre, $centroCosto, $cargo, $sueldo, $identifiacion, $diasLaborados) {
        $this->nombre = $nombre;
        $this->centroCosto = $centroCosto;
        $this->cargo = $cargo;
        $this->sueldo = $sueldo;
        $this->identifiacion = $identifiacion;
        $this->diasLaborados = $diasLaborados;
    }

    public function getDiasLaborados(){
        return $this->diasLaborados;
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
    public function setDiasLaborados($diasLaborados){
        $this->diaslaborados = $diasLaborados;
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
    public function __toString() {
        return "Nombre: ".$this->nombre.
               " Centro de Costo: ".$this->centroCosto.
               " Cargo: ".$this->cargo.
               " Sueldo: ".$this->sueldo.
               " Identificación: ".$this->identifiacion.
               " Días Laborados: ".$this->diasLaborados;
    }
    
    public static function obtenerTodos() {
        try {
            $db = new Database(); 
            $this->conexion = $db->conexion; 
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sql = "SELECT 
                        p.Nombre AS nombre,
                        cc.Nombre_CentroCosto AS centrocosto,
                        c.Nombre_Cargo AS cargo,
                        e.Salario AS sueldo,
                        p.ID_Cedula AS identificacion
                    FROM Empleado e
                    INNER JOIN Persona p ON e.ID_Persona = p.ID_Cedula
                    INNER JOIN Cargo c ON e.ID_Cargo = c.ID_Cargo
                    INNER JOIN Contrato co ON e.ID_Contrato = co.ID_Contrato
                    INNER JOIN CentroCosto cc ON co.ID_CentroCosto = cc.ID_CentroCosto";
    
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
    
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la conexión o consulta: " . $e->getMessage();
            return [];
        }
    }
    
}
?>
