<?php
class BaseDeDatos {
    public $pdo;

    public function __construct($server, $username, $dbname, $password) {
        try {
            $dsn = "mysql:host=$server;dbname=$dbname";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->manejoDeError($e);
        }
    }

    public function ejecutar($sql, $par = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($par);
            return $stmt; 
        } catch (PDOException $e) {
            $this->manejoDeError($e);
            return null;
        }
    }
    public function ejecutarId($sql, $par = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt; 
        } catch (PDOException $e) {
            $this->manejoDeError($e);
            return null;
        }
    }
    

    public function manejoDeError($exception) {
        echo "<script>console.error('Database Error: " . $exception->getMessage() . "');</script>";
    }
}

?>