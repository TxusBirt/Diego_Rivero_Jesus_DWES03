<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Index: está el controlador y se establecen las rutas y las acciones en 
            función de la solicitud
*/  
require '../core/Router.php';
require __DIR__.'/../app/controller/Vehiculocontroller.php';
require_once __DIR__ . '/../app/utilities/httpCode/ClientErrorCod.php';
//establezco la url base sobre la que luego la api trabaja
$url = $_SERVER['QUERY_STRING'];
//echo 'URL = ' .$url. '<br>';
//recojo los parametros que me viene por url y en funicón de ellos redirijo hacia el controlador y metodo a aplicar
$router = new Router();

$router->add('/public/vehiculocontroller/get', array(
    'controller' => 'Vehiculocontroller',
    'action'=>'getAllVehiculos'
    )
);
$router->add('/public/vehiculocontroller/get/{id}', array(
    'controller' => 'Vehiculocontroller',
    'action'=>'getVehiculoById'
    )
);
$router->add('/public/vehiculocontroller/create', array(
    'controller' => 'Vehiculocontroller',
    'action'=>'createVehiculo'
    )
);

$router->add('/public/vehiculocontroller/update/{id}', array(
    'controller' => 'Vehiculocontroller',
    'action'=>'updateVehiculo'
    )
);

$router->add('/public/vehiculocontroller/delete/{id}', array(
    'controller' => 'Vehiculocontroller',
    'action'=>'deleteVehiculo'
    )
);

// Controlador central: punto de entrada único para todas las consultas

$urlParams = explode('/',$url);

$urlArray = array(
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url,
    'controller' => '',
    'action' => '',
    'params' => ''
);

//validacion

if (!empty($urlParams[2])) {
    
    // si la url no coincide sale error 404
    if($urlParams[2] != 'vehiculocontroller') {
        return ClientErrorCod::notFound((['error' => 'URL incorrecta. Controlador no existe']));
    } else {
        $urlArray['controller'] = ucwords($urlParams[2]);
        if (!empty($urlParams[3])) {
            if ($urlParams[3]== 'get' || $urlParams[3]== 'create' || $urlParams[3]== 'update' || $urlParams[3]== 'delete') {
                $urlArray['action'] = $urlParams[3];
                if (!empty($urlParams[4])) {
                    $urlArray['params'] = $urlParams[4];   
                } 
                
            } else {
                return ClientErrorCod::notFound((['error' => 'metodo desconocido']));
            }
            //no siempre es necesario

        }
        else {
            return ClientErrorCod::notFound((['error' => 'URL incorrecta. Establezca un metodo']));
        }
    }
} else {
    return ClientErrorCod::notFound((['error' => 'URL incorrecta. Controlador sin definir']));
}
// establece accion a realizar en funcion de la url
if ($router->matchRoute($urlArray)) {
    $method = $_SERVER['REQUEST_METHOD'];

    $params = [];

    if ($method === 'GET') {

        $params[] = intval($urlArray['params']) ?? null;

    } elseif ($method === 'POST') {

        $json = file_get_contents('php://input');
        $params[] = json_decode($json,true);

    } elseif ($method === 'PUT') { 

        $id = intval($urlArray['params']) ?? null;
        $json = file_get_contents('php://input');
        $params[] = $id;
        $params[] = json_decode($json,true);

    } elseif ($method === 'DELETE') {
        $params[] = intval($urlArray['params']) ?? null;
    }

    $controller = $router->getParams()['controller'];
    $action = $router->getParams()['action'];
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $resp = call_user_func_array([$controller, $action], $params);
    } else {
        ClientErrorCod::notFound((['error' => 'URL incorrecta. No existe el metodo']));
    }
} else {
    ClientErrorCod::notFound((['error' => 'Parametro id no existe']));
}