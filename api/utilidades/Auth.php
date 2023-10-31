<?php
//AREA DE IMPORTACION//
include ("API_CLASS.php");

class Auth{
    //esta clase tiene que hacer 3 cosas
    //Primero, tiene que recivir y leer la lista de usuarios
    //Segundo, tiene que comparar el nombre de usuario, email y token para confirmar que no esten repedidos en la base de datos
    //Tercero en caso de pedidos, tiene que comparar los datos con el token, y si es un toquen valido devolver la informacion especifica pedida
    //Interactuar con la clase api para login y registrarse.
    public $conexion_db;
    public $api;
    public function __construct($conexion){
        $this->conexion_db = $conexion;
        $this->api = new API($this->conexion_db);
    }

    public function register($token, $data){
        
        if (isset($data['username']) && isset($data['email'])){//confirmo que los valores username y email esten en la peticion post
            $username = $data['username'];
            $email= $data['email'];

            $usuarioExistente = $this->confirmarExistencias($username, $email);//uso el metodo confirmarExistencias para verificar si estan en la base de datos

            if(!$usuarioExistente){//si no existe el usuario o email:
                $password = $data['password'];
                $date = date("Y-m-d");

                $this->api->endpointCrear($username, $password, $email, $date, $token); 
            }else{
                echo ("El nombre de usuario o el correo electronico ya estan registrados");
            }
        }else{
            echo ("Datos incompletos o erroneos");
        }
    }

    public function login($token, $data){

        if (isset($data['username']) && isset($data['password'])){
            $username = $data['username'];
            $password = $data['password'];

            $confirmar_usuario = $this->autentificarUsuario($username,$password);

            if ($confirmar_usuario){//si no retorno false la funcion o sea existe la convinacio usuario contraseña
                echo (json_encode(array('message' => 'Inicio de sesión exitoso: ', 'token: ' => $token)));
                echo ("logeado");
            }else{
                echo("La contraseña o el nombre de usuario no son correctos");
            }
        }else{
            echo("Datos de login incompletos");
            print_r($data);
        }
    }

    private function confirmarExistencias($username, $email){
        $sql = "SELECT * FROM users WHERE  username = :username OR email =:email";//consulta
        $par = array(':username' => $username,':email' => $email);//parametros para ejecutar la consulta
        $stmt = $this->conexion_db->ejecutar($sql,$par);//ejecucion desde la clase basededatos de conexion.php

        return $stmt->rowCount() > 0;//retorna un boleano dependiendo de si hay 1 o mas coinciddencias o no.
    }

    private function autentificarUsuario($username, $password){
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $par = array(':username' => $username, ':password'=> $password);
        $stmt = $this->conexion_db->ejecutar($sql,$par);

        return $stmt->fetch(PDO::FETCH_ASSOC);//retorna flase si la combinacion de usuario contraseña no existe o no es correcta.

    }
    


}
?>