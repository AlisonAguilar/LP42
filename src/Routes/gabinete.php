<?php

use App\Controllers\gabineteController;
use App\Config\responseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //capturamos el metodo que se envia
$route = $_GET['route']; //capturamos la ruta 
$params = explode('/', $route); // hacemos un explode de route ya que si nos envian user/email/clave tendriamos un array 
$data = json_decode(file_get_contents("php://input"),true); //contendra la data que enviemos por cualquier metodo excepto el get, array asociativo 
$headers = getallheaders(); //capturando todas las cabeceras que nos envian
/*
print_r($headers);
print_r($data);
print_r($_GET);
print_r($params);
print_r($route);
print_r($method);
*/
$caso = filter_input(INPUT_GET,"caso"); 
switch($caso){
    case 'guardarGabinete':
        //Una de las formas de pasar los valores (manual ahora) 
        $data['nombreGabinete'] = filter_input(INPUT_POST,"nombreGabinete");
        $data['direccion'] = filter_input(INPUT_POST,"direccion");
        $data['telefono'] = filter_input(INPUT_POST,"telefono");
        $data['correo'] = filter_input(INPUT_POST,"correo");
        $gabineteController = new gabineteController($method,$route,$params,$data,$headers);
        $gabineteController->guardarGabinete($route);
        break;
    case 'eliminarGabinete':
        //Una de las formas de pasar los valores (manual ahora) 
        $data['idgabinete'] = filter_input(INPUT_GET,"idgabinete");
        $gabineteController = new gabineteController($method,$route,$params,$data,$headers);
        $gabineteController->eliminarGabinete($route);
        break;
    case 'buscarGabinete':
        //Una de las formas de pasar los valores (manual ahora) 
        $data['idgabinete'] = filter_input(INPUT_GET,"idgabinete");
        $gabineteController = new gabineteController($method,$route,$params,$data,$headers);
        $gabineteController->buscarGabinete($route);
        break;
    case 'actualizarGabinete':        
        //Una de las formas de pasar los valores (manual ahora) 
        $data['idgabinete'] = filter_input(INPUT_GET,"idgabinete");
        $gabineteController = new gabineteController($method,$route,$params,$data,$headers);
        $gabineteController->actualizarGabinete($route);
        break;
    default:
        echo json_encode(responseHTTP::status200('La ruta no existe!'));
        break;
    //default:
}