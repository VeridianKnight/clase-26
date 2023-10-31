<?php
// IMPORTACION DEL ARCHIVO CONEXION.PHP //
include 'conexion.php';
class ABM{
    public $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function agregar(Elementos $elemento) {
        $sql = "INSERT INTO users (username, password, email, created_at, updated_at, token) VALUES (?, ?, ?, ?, ?, ?)";
        $par = [$elemento->getUsername(), $elemento->getPassword(), $elemento->getEmail(), $elemento->getDate(), $elemento->getDate(), $elemento->getToken()];
        $this->conexion->ejecutar($sql, $par);
    }

    public function editar(Elementos $elemento){
        $sql = "UPDATE users SET username = ?, password = ?, email = ?, updated_at=? WHERE id = ?";
        $par= [$elemento->getUsername(), $elemento->getPassword(), $elemento->getEmail(), $elemento->getDate(), $elemento->getId()];
        $this->conexion->ejecutar($sql,$par);
    }

    public function  eliminar(Elementos $elemento){
        $sql = "DELETE from users WHERE id=?";
        $par= [$elemento->getId()];
        $this->conexion->ejecutar($sql,$par);
    }

    public function listar($id = null) {
        
        try {
            if ($id !== null) {
                $sql = "SELECT * FROM users WHERE id = :id";
                $stmt = $this->conexion->ejecutarId($sql);
                echo("listando con id");
            } else {
                $sql = "SELECT * FROM users";
                $stmt = $this->conexion->ejecutar($sql);
            }
            
            if ($stmt) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return array(); 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array();
        }
    }
    
    
    public function menu(){
        //ah completar despues
    }

}
?>