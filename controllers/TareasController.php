<?php

class TareasController
{
    private $db;
    private $tareas;
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $datebase = new Database();
        $this->db = $datebase->connect();
        $this->tareas = new Tareas($this->db);
    }

    
    public function index()
    {
        include 'views/layouts/pie.php';
        include 'views/tareas/index.php';
        include 'views/layouts/cabeza.php';
        
    }

    public function obtenerTarea()
    {
        header('Content-Type: application/json');
        try {
            $resultado = $this->tareas->obtenerTarea();
            $tareas = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'data' => $tareas

            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function guardar()
    {
        header('Content-Type: application/json');

        try {
            if (empty($_POST['titulo']) || empty($_POST['descripcion']) || 
            empty($_POST['fecha_creacion']) || empty($_POST['fecha_vencimiento']) ||
             !isset($_POST['completada']) || empty($_POST['prioridad'])) {
                throw new Exception('Los campos son requeridos');
            }
            
            $this->tareas->titulo = $_POST['titulo'];
            $this->tareas->descripcion = $_POST['descripcion'];
            $this->tareas->fecha_creacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));
            $this->tareas->fecha_vencimiento = date('Y-m-d H:i:s', strtotime($_POST['fecha_vencimiento']));
            $this->tareas->completada = $_POST['completada'];
            $this->tareas->prioridad = $_POST['prioridad'];
            // var_dump($this->tareas);

            if ($this->tareas->crearTarea()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'La Tarea fue creada exitosamente',
                ]);
            } else {
                throw new Exception('Error al registrar Producto');
            };
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function actualizarTarea()
    {
        header('Content-Type: application/json');
        try {
          
            
            if (empty($_POST['titulo']) || empty($_POST['descripcion']) || 
            empty($_POST['fecha_creacion']) || empty($_POST['fecha_vencimiento']) ||
             !isset($_POST['completada']) || empty($_POST['prioridad'])) {
                throw new Exception('Los campos son requeridos');
            }
            
           $this->tareas->id_tareas = $_POST['id']; 
           $this->tareas->titulo = $_POST['titulo']; 
           $this->tareas->descripcion = $_POST['descripcion']; 
           $this->tareas->fecha_creacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));
           $this->tareas->fecha_vencimiento = date('Y-m-d H:i:s', strtotime($_POST['fecha_vencimiento']));
           $this->tareas->completada = $_POST['completada'];
           $this->tareas->prioridad = $_POST['prioridad']; 

           // Manejo de imagen
          

            if($this->tareas->actualizarTarea()){
                echo json_encode([
                    'status'=>'success', 
                   'message' => 'tarea actualizada correctamente',
                ]);
            }else{
                throw new Exception('Error al actualizar tarea');
            }

        } catch (Exception $e) {
            echo json_encode([
                'status'=> 'error', 
                'message' => $e->getMessage() 
            ]);
        }  
    }

    public function eliminarTarea()
    {
        header('Content-Type: application/json');
        try {
            $data = json_decode(file_get_contents("php://input")); 
            $this->tareas->id_tareas = $data->id_tareas;

            if($this->tareas->eliminarTareas()){
                echo json_encode([
                    'status'=>'success', 
                   'message' => 'producto eliminado correctamente',
                ]);
            }else{
                throw new Exception('Error al eliminar producto');
            }

        } catch (Exception $e) {
            echo json_encode([
                'status'=> 'error', 
                'message' => $e->getMessage() 
            ]);
        }
    } 
}


