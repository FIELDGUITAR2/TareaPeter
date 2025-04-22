<?php
class Nomina {
    private $empleado; // objeto de la clase Empleado


   
    public function __construct($empleado) {
        $this->empleado = $empleado;
        try {
        $this->db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

   

    // Obtener todos los registros de nómina
    public function obtenerNominas() {
try {
        $query = $this->db->prepare("SELECT * FROM nominas");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
            die("Error al obtener las nóminas: " . $e->getMessage());
        }
    }

    // Agregar un nuevo registro de nómina
    public function agregarNomina($datos) {
try {
        $query = $this->db->prepare("INSERT INTO nominas (campo1, campo2, campo3) VALUES (:valor1, :valor2, :valor3)");
        $query->bindParam(':valor1', $datos['campo1']);
        $query->bindParam(':valor2', $datos['campo2']);
        $query->bindParam(':valor3', $datos['campo3']);
        $query->execute();
} catch (PDOException $e) {
            die("Error al agregar la nómina: " . $e->getMessage());
        }
    }

    // Actualizar un registro de nómina existente
    public function actualizarNomina($id, $datosActualizados) {
try {
        $query = $this->db->prepare("UPDATE nominas SET campo1 = :valor1, campo2 = :valor2, campo3 = :valor3 WHERE id = :id");
        $query->bindParam(':valor1', $datosActualizados['campo1']);
        $query->bindParam(':valor2', $datosActualizados['campo2']);
        $query->bindParam(':valor3', $datosActualizados['campo3']);
        $query->bindParam(':id', $id);
        $query->execute();
} catch (PDOException $e) {
            die("Error al actualizar la nómina: " . $e->getMessage());
        }
    }

    // Eliminar un registro de nómina
    public function eliminarNomina($id) {
try {
        $query = $this->db->prepare("DELETE FROM nominas WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
} catch (PDOException $e) {
            die("Error al eliminar la nómina: " . $e->getMessage());
        }
    }
}
