<?php
class Database {
    private $host = "localhost";
    private $usuario = "root";
    private $contrasena = "123456";
    private $base_datos = "Nomina";

    public $conexion;

    public function __construct() {
        $this->conectar();
    }

    public function conectar() {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->contrasena,
            $this->base_datos
        );

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        echo "Conexión exitosa<br>";
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}