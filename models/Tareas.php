<?php
//models/Producto.php
class Tareas {
    private $conn;

    public $id_tareas;
    public $titulo;
    public $descripcion;
    public $fecha_creacion;
    public $fecha_vencimiento;  
    public $completada;  
    public $prioridad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTarea() {
        $query = "SELECT * FROM tareas ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crearTarea() {
        $query = "INSERT INTO tareas 
        (titulo, descripcion, fecha_creacion, fecha_vencimiento, prioridad) 
        VALUES (:titulo, :descripcion, :fecha_creacion, :fecha_vencimiento, :prioridad)";

$stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':fecha_creacion', $this->fecha_creacion);
        $stmt->bindParam(':fecha_vencimiento', $this->fecha_vencimiento);
        $stmt->bindParam(':prioridad', $this->prioridad);
       

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // public function read_single() {
    //     $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':id', $this->id);
    //     $stmt->execute();
        
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if($row) {
    //         $this->name = $row['name'];
    //         $this->description = $row['description'];
    //         $this->price = $row['price'];
    //         $this->stock = $row['stock'];
    //         $this->image = $row['image'];
    //         return true;
    //     }
    //     return false;
    // }

    public function actualizarTarea() {
        $query = "UPDATE 
                SET titulo = :titulo, 
                    descripcion = :descripcion,  
                    fecha_vencimiento  = :fecha_vencimiento , 
                    completada = :completada";
                if ($this->prioridad) {
                    $query .= ", prioridad = :prioridad";
                };
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':fecha_vencimiento', $this->fecha_vencimiento);
        $stmt->bindParam(':completada', $this->completada);
        $stmt->bindParam(':id_tareas', $this->id_tareas);
        
        if ($this->prioridad) {
            $stmt->bindParam(':prioridad', $this->prioridad);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function eliminarTareas() {
        $query = "DELETE FROM tareas  WHERE id_tareas = :id_tareas";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tareas', $this->id_tareas);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // public function search($term) {
    //     $query = "SELECT * FROM " . $this->table . " 
    //              WHERE name LIKE :term 
    //              ORDER BY name ASC";
        
    //     $term = "%{$term}%";
        
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':term', $term);
        
    //     $stmt->execute();
    //     return $stmt;
    // }
}