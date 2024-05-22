<?php

class conexion {
    
    protected $conec;
    
    public function __construct() {
        try {
            $this->conec = new PDO("mysql:host=localhost;dbname=apuestatotal_prueba", "root", "");
            $this->conec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Conexión fallida: " . $e->getMessage();
        }
    }

    public function getConexion() {
        return $this->conec;
    }

    public function cerrarConexion() {
        $this->conec = null;
    }
    
}