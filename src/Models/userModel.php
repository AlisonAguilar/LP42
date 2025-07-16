<?php
namespace App\Models;
use App\DB\connectionDB;
use App\DB\sql;
use App\Config\responseHTTP;
use App\Config\Security;
class userModel extends connectionDB{
    private static $nombre;
    private static $dni;
    private static $email;
    private static $rol;
    private static $clave;
    private static $confirmaClave;
    private static $IDToken;
    private static $fecha;

    //constructor
    public function __construct(array $data){
        self::$nombre = $data['nombre'];
        self::$dni = $data['dni'];
        self::$email = $data['email'];
        self::$rol = $data['rol'];
        self::$clave = $data['clave'];
        self::$confirmaClave = $data['confirmaClave'];
        self::$IDToken = $data['IDToken'];
        self::$fecha = $data['fecha'];
    }
    //metodos gets
    final public static function getNombre(){return self::$nombre;}
    final public static function getDni(){return self::$dni;}
    final public static function getEmail(){return self::$email;}
    final public static function getRol(){return self::$rol;}
    final public static function getClave(){return self::$clave;}
    final public static function getConfirmaClave(){return self::$confirmaClave;}
    final public static function getIDToken(){return self::$IDToken;}
    final public static function getFecha(){return self::$fecha;}
    //metodos set
    final public static function setNombre($nombre){self::$nombre = $nombre;}
    final public static function setDni($dni){self::$dni = $dni;}
    final public static function setEmail($email){self::$email = $email;}
    final public static function setRol($rol){self::$rol = $rol;}
    final public static function setClave($clave){self::$clave = $clave;}
    final public static function setConfirmaClave($confirmaClave){self::$confirma=$confirmaClave;}
    final public static function setIDToken($IDToken){self::$IDToken = $IDToken;}
    final public static function setFecha($fecha){self::$fecha = $fecha;}

    //metodo registrar usuario 
    final public static function post(){
        //validamos que el registro no se encuentre registrado en nuestra BD una doble validación por dni o correo
       // echo self::getDni();
        if(sql::verificarRegistro('CALL ConsultarAbogadoDNI(:dni)',':dni', self::getDni())){
            return responseHTTP::status400('El DNI esta registrado en la BD');            
        }else if(sql::verificarRegistro('CALL ConsultarAbogadoEmail(:email)', ':email',self::getEmail())){
            return responseHTTP::status400('El correo esta registrado en la BD');            
        }else{
            //si no esta registrado procedemos a insertar el registro
            //necesitamos enviar el token en el que especificamos el metodo de encriptacion y la info que encriptaremos
            self::setIDToken(hash('sha512', self::getDni().self::getEmail())); //nos permitira registrar, actualizar o eliminar el abogado (usuario)
            self::setFecha(date("d-m-y H:i:s")); //fecha de creacion

            try {
                $con = self::getConnection();
                 //$query = "INSERT INTO tbl_abogados (nombre, dni, email, rol, clave, confirmaClave, IDToken, fecha) 
                 //VALUES (:nombre, :dni, :email, :rol, :clave, :confirmaClave, :IDToken, :fecha)";
                 $query = "CALL RegistrarAbogado(:nombre, :dni, :email, :rol, :clave, :confirmaClave, :IDToken, :fecha)";
                    $stmt = $con->prepare($query);
                    $stmt->execute([
                        ':nombre' => self::getNombre(),
                        ':dni' => self::getDni(),
                        ':email' => self::getEmail(),
                        ':rol' => self::getRol(),
                        ':clave' => password_hash(self::getClave(), PASSWORD_DEFAULT),
                        ':confirmaClave' => self::getConfirmaClave(),
                        ':IDToken' => self::getIDToken(),
                        ':fecha' => self::getFecha()
                    ]);
                    
                    if($stmt->rowCount() > 0){
                        return responseHTTP::status200('Se ha registrado el abogado exitosamente!!!');
                    }else{
                        return responseHTTP::status500('Error al registrar el abogado!!!');
                    }
            } catch (\PDOException $e) {
                error_log('userModel::post -> '.$e);
                die(json_encode(responseHTTP::status500("HOLA")));
            }
           
        }
    }

    //metodo login 
    final public static function login(){
       // echo "llegamos al model";
        try {
            $con = self::getConnection(); //abrimos conexion
            $query = "CALL Login(:email)"; //hacemos la consulta para validar la info
            $stmt = $con->prepare($query); //preparamos query
            $stmt->execute([ //pasamos los parametros
                        ':email' => self::getEmail()
                    ]);
                    
            if($stmt->rowCount() == 0){ //contamos los registros retornados
                return responseHTTP::status400('Usuario o Contraseña incorrectas!!!');
            }else{ //si vienen datos
                
                foreach ($stmt as $val) {
                     //validamos que la contraseña que se ingreso sea igual al hash que tenemos en la BD                   
                     if(Security::validatePassword(self::getClave(), $val['clave'])){
                        //si las claves son igual entonces construyo el Payload de mi JWT  
                        $payload =[
                            'IDToken' => $val['IDToken']
                        ];
                        //creo el token 
                        $token = Security::createTokenJwt(Security::secretKey(),$payload);
                        //datos que le mostraremos a el usuario
                        $data = [
                            'nombre' => $val['nombre'],
                            'rol' => $val['rol'],
                            'token' => $token,
                            'access' => 1,
                        ];
                        
                        return($data);
                        //retorno la data
                        
                     }else{
                        return responseHTTP::status400('Usuario o Contraseña incorrectas1!!!');
                     }
                }
            }
        } catch (\PDOException $e) {
            error_log("userModel::Login -> ".$e);
            die(json_encode(responseHTTP::status500()));
        }
    }

    //metodo para retornar todos los abogados
    final public static function getAll(){
           try {
                $con = self::getConnection(); //abrimos conexion
                $query = "CALL ConsultarAbogados()"; //hacemos la consulta para validar la info
                $stmt = $con->prepare($query); //preparamos query
                $stmt->execute();
                $res = $stmt->fetchAll(\PDO::FETCH_ASSOC); //pasamos los resultados a un array
                return $res;
                    
           } catch (\PDOException $e) {
                error_log("userModel::getALL -> ".$e);
                die(json_encode(responseHTTP::status500()));
           }
    }
    //metodo que retorna un abogado por DNI
    final public static function getUser(){
           try {
                $con = self::getConnection(); //abrimos conexion
                $query = "CALL ConsultarAbogadoDNI(:dni)"; //hacemos la consulta
                $stmt = $con->prepare($query); //preparamos query
                $stmt->execute([ //pasamos los parametros
                        ':dni' => "".self::getDni()
                    ]);
                if($stmt->rowCount() > 0){
                    $res['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC); //pasamos los resultados a un array
                    return $res;
                }else{
                    return responseHTTP::status400('No existe registro con el DNI ingresado!');
                }
           } catch (\PDOException $e) {
                error_log("userModel::getUser -> ".$e);
                die(json_encode(responseHTTP::status500()));
           }
    }

     //metodo que permite validar si la contraseña antigua es correcta
    final public static function validateOldPassword($IDToken, $oldPassword){
           try {
                $con = self::getConnection(); //abrimos conexion
                $query = "CALL ConsultarClave(:IDToken)"; //hacemos la consulta
                $stmt = $con->prepare($query); //preparamos query
                $stmt->execute([ //pasamos los parametros
                        ':IDToken' => $IDToken
                    ]);
                //verificamos que venga un registro
                if($stmt->rowCount() == 0){
                    die(json_encode(responseHTTP::status500()));
                //si viene un registro
                }else{
                    //array asociativo
                    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
                    //verificamos si la contraseña antigua es correcta
                    if(Security::validatePassword($oldPassword, $res['clave'])){                        
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                
                }
           } catch (\PDOException $e) {
                error_log("userModel::getUser -> ".$e);
                die(json_encode(responseHTTP::status500()));
           }
    }
}