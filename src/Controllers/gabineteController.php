<?php

namespace App\Controllers;

use App\Models\gabineteModel;
use App\Config\responseHTTP;
use App\Config\Security;
class gabineteController{
    private $method;
    private $route;
    private $params;
    private $data;
    private $headers; 

 
    private static $validar_rol = '/^[1,2,3]{1,1}$/'; //validamos el rol (1 = "", 2="", 3="")
    private static $validar_numero = '/^[0-9]+$/'; //validamos numeros (0-9)
    private static $validar_texto = '/^[a-zA-Z]+$/'; //validamos texto (a-z y A-Z)

    public function __construct($method,$route,$params,$data,$headers){        
        $this->method = $method;        
        $this->route = $route;
        $this->params = $params;
        $this->data = $data;
        $this->headers = $headers;            
    }
    

    final public function getAll($endpoint){  
       //print_r($_GET);      
             //validamos method y endpoint 
        if($this->method == 'get' && $endpoint == $this->route){ 
            //print_r($_GET);
            //validamos JWT, enviando header y clave secreta
            //Security::validateTokenJwt($this->headers, Security::secretKey());  
            return gabineteModel::getAll();            
            exit;
        }
    }

    
    //metodo que recibe un endpoint (ruta a un recurso) para poder registrarlo en la BD
    final public function guardarGabinete($endpoint){
               
        //validamos method y endpoint         
        if($this->method == 'post' && $endpoint == $this->route){             
            //linea que agregamos para proteger la petición post (se explica en la actualizacion de registros)
            //validamos JWT, enviando header y clave secreta
            //AHORA ESTA COMENTADA PARA PROCEDER CON EL EJEMPLO DE REGISTRO
            //Security::validateTokenJwt($this->headers, Security::secretKey());
            //validamos que los campos no vengan vacios
            //echo "llega a guardar gabinete";	
            if (empty($this->data['nombreGabinete']) || empty($this->data['direccion']) || empty($this->data['telefono']) || empty($this->data['correo'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos, proceda a llenarlos.'));
                //validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            }else if (!preg_match(self::$validar_texto, $this->data['nombreGabinete'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre Gabinete debe ingresar solo texto.'));
                //validamos que los campos numericos sean contengan solo numeros mediante preg_match evaluamos expresiones regulares
            } else if (!preg_match(self::$validar_numero,$this->data['telefono'])) {
                echo json_encode(responseHTTP::status400('En el campo dni debe ingresar solo numeros.'));
                //validamos que el correo tenga el formato correcto 
                //filter_var permite crear un filtro especifico y luego validar a partir de este
            }  else if (!filter_var($this->data['correo'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(responseHTTP::status400('El correo debe tener el formato correcto.'));
                //validamos el rol 
            } else {
                //echo 'ss1';
                 new gabineteModel($this->data);
                echo json_encode(gabineteModel::guardarGabinete());
            }
            
        }
        exit;

    }
    

    //metodo que recibe un endpoint (ruta a un recurso) para poder eliminarlo en la BD
    final public function eliminarGabinete($endpoint){
        //    print_r($this->data);   
        //validamos method y endpoint         
        if($this->method == 'delete' && $endpoint == $this->route){             
           
            //AHORA ESTA COMENTADA PARA PROCEDER CON EL EJEMPLO DE ELIMINAR
            //Security::validateTokenJwt($this->headers, Security::secretKey());
            //validamos que los campos no vengan vacios
            if (empty($this->data['idgabinete'])) {
                echo json_encode(responseHTTP::status400('Para proceder debe seleccionar un gabinete.'));
                //validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            } else {
                 new gabineteModel($this->data);
                echo json_encode(gabineteModel::eliminarGabinete());
            }
            
        }
        exit;

    }

    //metodo que recibe un endpoint (ruta a un recurso) para poder editar 
    final public function buscarGabinete($endpoint){
        //    print_r($this->data);   
        //validamos method y endpoint         
        if($this->method == 'put' && $endpoint == $this->route){             
           
            //AHORA ESTA COMENTADA PARA PROCEDER CON EL EJEMPLO DE editar
            //Security::validateTokenJwt($this->headers, Security::secretKey());
            //validamos que los campos no vengan vacios
            if (empty($this->data['idgabinete'])) {
                echo json_encode(responseHTTP::status400('Para proceder debe seleccionar un gabinete.'));
                //validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            } else {
                 new gabineteModel($this->data);
                echo json_encode(gabineteModel::buscarGabinete());
            }
            
        }
        exit;

    }

    final public function actualizarGabinete($endpoint){
         //  print_r($this->data);    
        //validamos method y endpoint         
        if($this->method == 'put' && $endpoint == $this->route){             
            //linea que agregamos para proteger la petición post (se explica en la actualizacion de registros)
            //validamos JWT, enviando header y clave secreta
            //AHORA ESTA COMENTADA PARA PROCEDER CON EL EJEMPLO DE REGISTRO
            //Security::validateTokenJwt($this->headers, Security::secretKey());
            //validamos que los campos no vengan vacios
            //echo "llega a guardar gabinete";	
            if (empty($this->data['nombreGabinete']) || empty($this->data['direccion']) || empty($this->data['telefono']) || empty($this->data['correo'])) {
                echo json_encode(responseHTTP::status400('Todos los campos son requeridos, proceda a llenarlos.'));
                //validamos que los campos de texto sean de texto mediante preg_match evaluamos expresiones regulares
            }else if (!preg_match(self::$validar_texto, $this->data['nombreGabinete'])) {
                echo json_encode(responseHTTP::status400('En el campo nombre Gabinete debe ingresar solo texto.'));
                //validamos que los campos numericos sean contengan solo numeros mediante preg_match evaluamos expresiones regulares
            } else if (!preg_match(self::$validar_numero,$this->data['telefono'])) {
                echo json_encode(responseHTTP::status400('En el campo dni debe ingresar solo numeros.'));
                //validamos que el correo tenga el formato correcto 
                //filter_var permite crear un filtro especifico y luego validar a partir de este
            }  else if (!filter_var($this->data['correo'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(responseHTTP::status400('El correo debe tener el formato correcto.'));
                //validamos el rol 
            } else {
                //echo 'ss1';
                 new gabineteModel($this->data);
                echo json_encode(gabineteModel::actualizarGabinete());
            }
            
        }
        exit;

    }
    
    
} 