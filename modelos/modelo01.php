<?php

require './conexiones/conexion.php';

class consultasYregistros extends conexion{

    public function __construct(){
        parent::__construct();
    }

    public function get_user($parameter){
        $email = !empty($parameter['email']) ? $parameter['email'] : '';
        $Password = !empty($parameter['Password']) ? $parameter['Password'] : '';

        try {
            $stmt = $this->conec->prepare("CALL sp_get_user_login_v1(:email, :Password)");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':Password', $Password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function get_customer($parameter){
        $PlayerID = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : 0;
        $document = !empty($parameter['document']) ? $parameter['document'] : 0;
        $first_name = !empty($parameter['first_name']) ? $parameter['first_name'] : '';
        $last_name = !empty($parameter['last_name']) ? $parameter['last_name'] : '';

        try {
            $stmt = $this->conec->prepare("CALL sp_get_customer_v1(:PlayerID, :document, :first_name, :last_name)");
            $stmt->bindParam(':PlayerID', $PlayerID, PDO::PARAM_INT);
            $stmt->bindParam(':document', $document, PDO::PARAM_INT);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

}