<?php
// IMPORTACION DEL ARCHIVO ABM.PHP //
include 'ABM.php';
class Elementos{
    // PROPIEDADES DE LA CLASE //
    public $id;
    public $username;
    public $password;
    public $email;
    public $date;
    private $token;

    // CONSTRUCTOR DE LA CLASE //
    public function __construct($id = null, $username, $password, $email, $date, $token) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->date = $date;
        $this->token = $token;

    }
    

    // METODOS GET DE LA CLASE //
    public function getId(){
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getDate(){
        return $this->date;
    }

    public function getToken(){
        return $this->token;
    }

    // METODS SET DE LA CLASE //

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setToken($token) {
        $this->token = $token;
    }
    
}
?>