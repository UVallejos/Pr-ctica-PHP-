<?php

//Creamos un contrusctor, agregamos try, catch, indicamos conexión usando la clase PDO
class conexion{

    private $servidor = "localhost";
    private $usuario = "root";
    private $contrasenia = "";
    private $conexion;

    //Creamos constructor para iniciar la conexión al instanciar el objeto
    public function __construct(){

        try{
            $this->conexion = new PDO("mysql:host=$this->servidor;dbname=album", $this->usuario, $this->contrasenia);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            }
        catch(PDOException $e){
            return "Falla de conexión".$e;
        }

    }

    //Creamos funcion para ejecutar sentencias SQL que nos devuelve el id de la consulta incertada
    public function ejecutar($sql){
 
        $this->conexion->exec($sql);
        return $this->conexion->lastInsertId();

    }

    //Creamos función para mostrar todos los registros de la tabla que ocuparemos en portafolio.php 
    public function consultar($sql){

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();

    }


}

?>