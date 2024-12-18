<?php
///include"./config/Database.php";
//$db = new Database;
//$valida = $db->connect();
//if ($valida) {
//    echo "conexion establecida";
//}else{
//    echo "Error en la conexion";
//}

error_reporting (E_ALL);
ini_set('display_errors', 1);

//CARGAR EL ARCHIVO DE CONFIGUARACION
require_once'config/config.php';

//autoload de classes 
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            // var_dump($file);
            require_once $file;
            return;
        }
    }
});

//crear una instancia  de router    
$router = new Router;

$public_routes = [
    '/web',
    '/login',
    '/register',
];

//obtener  la ruta actual
$current_router = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$current_router = str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$current_router);
//$current_router = la ruta despues de la carpeta del proyecto
// var_dump(dirname($_SERVER['SCRIPT_NAME']));
// var_dump($current_router);

$router ->add('GET','/web','webController', 'index');
//login register and register
$router ->add('GET','/login','AuthController', 'showLogin');
$router ->add('GET','/register','AuthController', 'showRegister');


$router ->add('POST','auth/login','AuthController', 'login');
$router ->add('POST','auth/register','AuthController', 'register');

///////home controller////////////////////////////////
$router ->add('GET','home','HomeController', 'index');

/////////crud///////////
$router ->add('GET','productos/','ProductoController', 'index');
$router ->add('GET','productos/obtener-todo','ProductoController', 'obtenerProducto');


$router ->add('POST','productos/guardar-producto','ProductoController', 'guardarProducto');
$router ->add('POST','productos/actualizar-producto','ProductoController', 'actualizarProducto');
$router ->add('DELETE','productos/eliminar-producto','ProductoController', 'eliminarProducto');
$router ->add('GET','productos/buscar-producto','ProductoController', 'buscarProducto');


////reporte en pdf y exel

$router ->add('GET','reporte/pdf','ReporteController', 'reportePdf');
$router ->add('GET','reporte/exel','ReporteController', 'reporteExel');

$router ->add('GET','report/pdf','ReportController', 'reportPdf');
$router ->add('GET','report/exel','ReportController', 'reportExel');




//////crud tareas//////

$router ->add('GET','tareas/','TareasController', 'index');
$router ->add('GET','tareas/obtener-todo','TareasController', 'obtenerTarea');
$router ->add('POST','tareas/guardar','TareasController', 'guardar');
$router ->add('POST','tareas/actualizar','TareasController', 'actualizarTarea');
$router ->add('DELETE','tareas/eliminar','TareasController', 'eliminarTarea');
$router ->add('GET','tareas/buscar','TareasController', 'buscarProducto');

//despachar la ruta actual
try {
    $router->dispatch($current_router, $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    // Manejar el error
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}



