<?php
namespace App\Models;
use App\DB\connectionDB;
use App\DB\sql;
use App\Config\responseHTTP;
use App\Config\Security;
class gabineteModel extends connectionDB{
    private static $nombre;
    private static $correo;
    private static $direccion;
    private static $telefono;
    private static $idGabinete;

    //constructor
    public function __construct(array $data){
        self::$nombre = $data['nombreGabinete'];
        self::$direccion = $data['direccion'];
        self::$correo = $data['correo'];
        self::$telefono = $data['telefono'];
        self::$idGabinete = $data['idgabinete'];
        
    }
    //metodos gets
    final public static function getNombre(){return self::$nombre;}
    final public static function getDireccion(){return self::$direccion;}
    final public static function getCorreo(){return self::$correo;}
    final public static function getTelefono(){return self::$telefono;}
    final public static function getIdGabinete(){return self::$idGabinete;}
    
    //metodos set
    final public static function setNombre($nombre){self::$nombre = $nombre;}    
    final public static function setDireccion($direccion){self::$direccion = $direccion;}
    final public static function setCorreo($correo){self::$correo = $correo;}
    final public static function setTelefono($telefono){self::$telefono = $telefono;}
    final public static function setIdGabinete($idGabinete){self::$idGabinete = $idGabinete;}


    //metodo para retornar todos los gabinetes
    final public static function getAll(){
        //print_r($_GET);
           try {
                $con = self::getConnection(); //abrimos conexion
                $query = "CALL ConsultarGabinetes()"; //hacemos la consulta para validar la info
                $stmt = $con->prepare($query); //preparamos query
                $stmt->execute();
                $res = $stmt->fetchAll(\PDO::FETCH_ASSOC); //pasamos los resultados a un array
                return $res;
                    
           } catch (\PDOException $e) {
                error_log("userModel::getALL -> ".$e);
                die(json_encode(responseHTTP::status500()));
           }
    }

    
    //metodo registrar gabinete 
    final public static function guardarGabinete(){
       
        //validamos que el registro no se encuentre registrado en nuestra BD una doble validación por dni o correo
       // echo self::getDni();
        if(sql::verificarRegistro('CALL ConsultarGabinete(:nombre)',':nombre', self::getNombre())){
            return responseHTTP::status400('El nombre del Gabinete ya esta registrado en la BD');            
        }else{
            //si no esta registrado procedemos a insertar el registro
            //necesitamos enviar el token en el que especificamos el metodo de encriptacion y la info que encriptaremos
            //self::setIDToken(hash('sha512', self::getDni().self::getEmail())); //nos permitira registrar, actualizar o eliminar el abogado (usuario)
            //self::setFecha(date("d-m-y H:i:s")); //fecha de creacion

            try {
                $con = self::getConnection();
                 //$query = "INSERT INTO tbl_abogados (nombre, dni, email, rol, clave, confirmaClave, IDToken, fecha) 
                 //VALUES (:nombre, :dni, :email, :rol, :clave, :confirmaClave, :IDToken, :fecha)";
                 $query = "CALL RegistrarGabinete(:nombre, :direccion, :correo, :telefono)";
                    $stmt = $con->prepare($query);
                    $stmt->execute([
                        ':nombre' => self::getNombre(),
                        ':direccion' => self::getDireccion(),
                        ':correo' => self::getCorreo(),
                        ':telefono' => self::getTelefono()                        
                    ]);                    
                    if($stmt->rowCount() > 0){
                        return responseHTTP::status200('Se ha registrado el gabinete exitosamente!!!');
                    }else{
                        return responseHTTP::status500('Error al registrar el gabinete!!!');
                    }
            } catch (\PDOException $e) {
                error_log('gabineteModel::post -> '.$e);
                die(json_encode(responseHTTP::status500("Error al registrar el gabinete!!!")));
            }
           
        }
    }   

     //metodo eliminar gabinete 
     final public static function eliminarGabinete(){     
        try {
            $con = self::getConnection();           
            $query = "CALL EliminarGabinete(:idgabinete)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':idgabinete' => self::getIdGabinete()                      
            ]);                    
            if($stmt->rowCount() > 0){
                return responseHTTP::status200('Se ha eliminado el gabinete exitosamente!!!');
            }else{
                return responseHTTP::status500('Error al eliminar el gabinete!!!');
            }
        } catch (\PDOException $e) {
            error_log('gabineteModel::get -> '.$e);
            die(json_encode(responseHTTP::status500("Error al eliminar el gabinete!!!")));
        }
    }   





     //metodo editar gabinete 
     final public static function buscarGabinete(){     
        try {
            $con = self::getConnection();           
            $query = "CALL BuscarGabinete(:idgabinete)";
            $stmt = $con->prepare($query);
            $stmt->execute([
                ':idgabinete' => self::getIdGabinete()                      
            ]);                    
            $res = $stmt->fetchAll(\PDO::FETCH_ASSOC); //pasamos los resultados a un array   
            $data;         
            foreach ($res as $key => $value) {
                $data['nombre'] = $value['nombre'];
                $data['direccion'] = $value['direccion'];
                $data['telefono'] = $value['telefono'];
                $data['correo'] = $value['correo'];   
            }
            return $data;
        } catch (\PDOException $e) {
            error_log('gabineteModel::get -> '.$e);
            die(json_encode(responseHTTP::status500("Error al eliminar el gabinete!!!")));
        }
    }
    
    
    final public static function actualizarGabinete(){
        try {
            $con = self::getConnection();
                //$query = "INSERT INTO tbl_abogados (nombre, dni, email, rol, clave, confirmaClave, IDToken, fecha) 
                //VALUES (:nombre, :dni, :email, :rol, :clave, :confirmaClave, :IDToken, :fecha)";
                $query = "CALL ActualizarGabinete(:id_gabinete, :nombre, :direccion, :correo, :telefono)";
                $stmt = $con->prepare($query);
                $stmt->execute([
                    ':id_gabinete' => self::getIdGabinete(),
                    ':nombre' => self::getNombre(),
                    ':direccion' => self::getDireccion(),
                    ':correo' => self::getCorreo(),
                    ':telefono' => self::getTelefono()                        
                ]);                    
                if($stmt->rowCount() > 0){
                    return responseHTTP::status200('Se ha actualizado el gabinete exitosamente!!!');
                }else{
                    return responseHTTP::status500('Error al actualizar el gabinete!!!');
                }
        } catch (\PDOException $e) {
            error_log('gabineteModel::post -> '.$e);
            die(json_encode(responseHTTP::status500("Error al actualizar el gabinete!!!")));
        }
    }   

}
