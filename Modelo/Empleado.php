<?php
class Empleado {
    public $id;
    public $nombre;
    public $apellido;
    public $centroCosto;
    public $cargo;
    public $sueldo;
    public $identificacion; // Corregido typo
    public $diasLaborados;
    public $salarioBase;
    public $tipoContrato;
    public $tieneDerechoAuxTransporte;
    public $auxAlimentacionNoPrestacional;
    private $nominaId;

    public function __construct($nombre, $apellido, $centroCosto, $cargo, $sueldo, $identificacion, $diasLaborados = 0, $salarioBase = 0, $tipoContrato = '', $tieneDerechoAuxTransporte = false, $auxAlimentacionNoPrestacional = 0) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->centroCosto = $centroCosto;
        $this->cargo = $cargo;
        $this->sueldo = $sueldo;
        $this->identificacion = $identificacion;
        $this->diasLaborados = $diasLaborados;
        $this->salarioBase = $salarioBase;
        $this->tipoContrato = $tipoContrato;
        $this->tieneDerechoAuxTransporte = $tieneDerechoAuxTransporte;
        $this->auxAlimentacionNoPrestacional = $auxAlimentacionNoPrestacional;
    }

    // Getters y Setters actualizados
    public function getId() { return $this->id; }
    public function getApellido() { return $this->apellido; }
    public function getSalarioBase() { return $this->salarioBase; }
    public function getTipoContrato() { return $this->tipoContrato; }
    public function getTieneDerechoAuxTransporte() { return $this->tieneDerechoAuxTransporte; }
    public function getAuxAlimentacionNoPrestacional() { return $this->auxAlimentacionNoPrestacional; }

    public function setId($id) { $this->id = $id; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setSalarioBase($salarioBase) { $this->salarioBase = $salarioBase; }
    public function setTipoContrato($tipoContrato) { $this->tipoContrato = $tipoContrato; }
    public function setTieneDerechoAuxTransporte($valor) { $this->tieneDerechoAuxTransporte = $valor; }
    public function setAuxAlimentacionNoPrestacional($valor) { $this->auxAlimentacionNoPrestacional = $valor; }
    public function setDiasLaborados($diasLaborados) { $this->diasLaborados = $diasLaborados; } // Corregido

    public function guardar() {
        $pdo = new PDO('mysql:host=localhost;dbname=nomina_db', 'usuario_nomina', 'contraseña_segura');
        if ($this->id) {
            // Actualización
            $stmt = $pdo->prepare("UPDATE empleados SET 
                nombre = ?, apellido = ?, centro_costo = ?, cargo = ?, sueldo = ?, 
                identificacion = ?, dias_laborados = ?, salario_base = ?, tipo_contrato = ?, 
                tiene_aux_transporte = ?, aux_alimentacion = ?, nomina_id = ? 
                WHERE id = ?");
            $stmt->execute([
                // ... otros campos
                $this->nominaId,
                $this->id
            ]);
        } else {
            // Inserción
            $stmt = $pdo->prepare("INSERT INTO empleados 
                (nombre, apellido, centro_costo, cargo, sueldo, identificacion, 
                dias_laborados, salario_base, tipo_contrato, tiene_aux_transporte, 
                aux_alimentacion, nomina_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                // ... otros campos
                $this->nominaId
            ]);
            $this->id = $pdo->lastInsertId();
        }
    }

    // Método para obtener la nómina asociada
    public function obtenerNomina() {
        if ($this->nominaId) {
            $pdo = new PDO('mysql:host=localhost;dbname=nomina_db', 'usuario_nomina', 'contraseña_segura');
            $stmt = $pdo->prepare("SELECT * FROM nominas WHERE id = ?");
            $stmt->execute([$this->nominaId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }


    // Método estático para obtener todos los empleados
    public static function obtenerTodos() {
        $pdo = new PDO('mysql:host=localhost;dbname=nomina_db', 'usuario_nomina', 'contraseña_segura');
        $stmt = $pdo->query("SELECT * FROM empleados");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Empleado');
    }

    // Método estático para eliminar un empleado
    public static function eliminar($id) {
        $pdo = new PDO('mysql:host=localhost;dbname=nomina_db', 'usuario_nomina', 'contraseña_segura');
        $stmt = $pdo->prepare("DELETE FROM empleados WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function __toString() {
        return "Nombre: {$this->nombre} {$this->apellido}, Identificación: {$this->identificacion}, Cargo: {$this->cargo}";
    }
}