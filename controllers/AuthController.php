<?php
class AuthController {
    private $db;
    private $usuario;
    public function __construct() 
    {
      $datebase = new Database();
      $this->db = $datebase->connect();
    }

    public function showLogin(){
        include 'views/auth/login.php';

    }

    public function showRegister(){
        include 'views/auth/register.php';
    }

    public function login(){
        header('Content-Type: application/json');
        try {
            throw new Exception('error josue');

            
        } catch (Exception $e) {
            echo json_encode([
                'status'=> 'error', 
                'message' => $e->getMessage() 
            ]);
            
        }
    }
}