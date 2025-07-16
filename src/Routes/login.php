<?php

use App\Controllers\userController;
use App\Config\responseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //capturamos el metodo que se envia
$route = $_GET['route']; //capturamos la ruta 
$params = explode('/', $route); // hacemos un explode de route ya que si nos envian user/email/clave tendriamos un array 
$data = json_decode(file_get_contents("php://input"),true); //contendra la data que enviemos por cualquier metodo excepto el get, array asociativo 
$headers = getallheaders(); //capturando todas las cabeceras que nos envian

$params[1] = filter_input(INPUT_GET,"usuario");
$params[2] = filter_input(INPUT_GET,"clave");   
$app = new userController($method,$route,$params,$data,$headers);
$app->getLogin('login');
exit;
echo json_encode(responseHTTP::status404()); //imprimamos un error en caso de no encuentre la ruta


