<?php
//AREA DE IMPORTACION//
include ("GET_SET_CLASS.php");
class API{

    public $conexion_db;
    public $abm;
    public function __construct($conexion){
        $this->conexion_db = $conexion;
        $this->abm = new ABM($this->conexion_db);
    }

    public function endpointObtener() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $id = (int)$data['id'];
            $listar = $this->abm->listar($id);
        } else {
            $listar = $this->abm->listar($id = null);
        }
        echo json_encode($listar);
    }
    

    public function endpointCrear($username, $password, $email, $date, $token) {

            $elemento = new Elementos($id=null, $username, $password, $email, $date, $token);// creo un nuevo objeto elementos con la info que auth le pasa
            
            $this->abm->agregar($elemento);//uso el methodo agregar de abm con el nuevo elemento
            echo('Usuario ' . $username . 'ah sido registrado con exito');//respuesta de registro exitoso
    }
    
    public function endpointActualizar($token){
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id']) && isset($data['username']) && isset($data['password']) && isset($data['email'])) {
            $id = $data['id'];
            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
    
            $date = date("Y-m-d");//devuelve la fecha atual
            $elemento = new Elementos($id, $username, $password, $email, $date, $token);
            
            $this->abm->editar($elemento);
            echo('Elemento' . $id . 'ah sido actualizado con exito');
        } else {
           echo('Error datos no correctos o faltan datos.');
        }
    }

    public function endpointBorrar(){
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])){
            $id = (int)$data['id'];

            $elemento = new Elementos($id, $username=null, $password=null, $email=null, $date=null, $token=null);

            $this->abm->eliminar($elemento);
            echo('Elemento' .$id . 'ah sido eliminado con exito');
        }else{
            echo('Error id invalido');
        }
    }

}
?>