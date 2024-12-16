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
}
