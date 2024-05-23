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

    public function get_customer_wallets($parameter){
        $PlayerID = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_get_customer_wallets_v1(:PlayerID)");
            $stmt->bindParam(':PlayerID', $PlayerID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function get_recharge($parameter){
        $PlayerID = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_get_recharge_v1(:PlayerID)");
            $stmt->bindParam(':PlayerID', $PlayerID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function get_customer_wallets_movements($parameter){
        $PlayerID = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_get_customer_wallets_movements_v1(:PlayerID)");
            $stmt->bindParam(':PlayerID', $PlayerID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function get_bank(){
        try {
            $stmt = $this->conec->prepare("CALL sp_get_bank_v1()");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function get_channel(){
        try {
            $stmt = $this->conec->prepare("CALL sp_get_channel_v1()");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

    public function post_recharge($parameter){
        $id_users = !empty($parameter['id_users']) ? $parameter['id_users'] : 0;
        $id_customer = !empty($parameter['id_customer']) ? $parameter['id_customer'] : 0;
        $id_bank = !empty($parameter['id_bank']) ? $parameter['id_bank'] : 0;
        $id_channel = !empty($parameter['id_channel']) ? $parameter['id_channel'] : 0;
        $amount = !empty($parameter['amount']) ? $parameter['amount'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_post_recharge_v1(:id_customer, :id_bank, :id_channel, :amount, :id_users)");
            $stmt->bindParam(':id_customer', $id_customer, PDO::PARAM_INT);
            $stmt->bindParam(':id_bank', $id_bank, PDO::PARAM_INT);
            $stmt->bindParam(':id_channel', $id_channel, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':id_users', $id_users, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['success'] = 'true';
            $_SESSION['type_alert'] = 'success';
            $_SESSION['msg'] = 'Recarga Realizada con exito.';
        } catch (PDOException $e) {
            $_SESSION['success'] = 'false';
            $_SESSION['type_alert'] = 'danger';
            $_SESSION['msg'] = $e->getMessage();
        }
    }

    public function set_asignar($parameter){
        $id_users = !empty($parameter['id_users']) ? $parameter['id_users'] : 0;
        $id_recharge = !empty($parameter['id_recharge']) ? $parameter['id_recharge'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_set_asignar_recharge_v1(:id_recharge, :id_users)");
            $stmt->bindParam(':id_recharge', $id_recharge, PDO::PARAM_INT);
            $stmt->bindParam(':id_users', $id_users, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['success'] = 'true';
            $_SESSION['type_alert'] = 'success';
            $_SESSION['msg'] = 'Se asigno el saldo con exito.';
        } catch (PDOException $e) {
            $_SESSION['success'] = 'false';
            $_SESSION['type_alert'] = 'danger';
            $_SESSION['msg'] = $e->getMessage();
        }
    }

    public function set_anular($parameter){
        $id_users = !empty($parameter['id_users']) ? $parameter['id_users'] : 0;
        $id_recharge = !empty($parameter['id_recharge_anular']) ? $parameter['id_recharge_anular'] : 0;
        $motive = !empty($parameter['motivo_anular']) ? $parameter['motivo_anular'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_set_anular_recharge_v1(:id_recharge, :id_users, :motive)");
            $stmt->bindParam(':id_recharge', $id_recharge, PDO::PARAM_INT);
            $stmt->bindParam(':id_users', $id_users, PDO::PARAM_INT);
            $stmt->bindParam(':motive', $motive, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['success'] = 'true';
            $_SESSION['type_alert'] = 'success';
            $_SESSION['msg'] = 'Se anulo la recarga con exito.';
        } catch (PDOException $e) {
            $_SESSION['success'] = 'false';
            $_SESSION['type_alert'] = 'danger';
            $_SESSION['msg'] = $e->getMessage();
        }
    }

    public function set_editar($parameter){
        $id_users = !empty($parameter['id_users']) ? $parameter['id_users'] : 0;
        $id_recharge = !empty($parameter['id_recharge_edit']) ? $parameter['id_recharge_edit'] : 0;
        $id_bank = !empty($parameter['id_bank_edit']) ? $parameter['id_bank_edit'] : 0;
        $id_channel = !empty($parameter['id_channel_edit']) ? $parameter['id_channel_edit'] : 0;
        $amount = !empty($parameter['amount_edit']) ? $parameter['amount_edit'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_set_editar_recharge_v1(:id_recharge, :id_users, :id_bank, :id_channel, :amount)");
            $stmt->bindParam(':id_recharge', $id_recharge, PDO::PARAM_INT);
            $stmt->bindParam(':id_users', $id_users, PDO::PARAM_INT);
            $stmt->bindParam(':id_bank', $id_bank, PDO::PARAM_INT);
            $stmt->bindParam(':id_channel', $id_channel, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['success'] = 'true';
            $_SESSION['type_alert'] = 'success';
            $_SESSION['msg'] = 'Se edito la recarga con exito.';
        } catch (PDOException $e) {
            $_SESSION['success'] = 'false';
            $_SESSION['type_alert'] = 'danger';
            $_SESSION['msg'] = $e->getMessage();
        }
    }

    public function get_recharge_cancel($parameter){
        $PlayerID = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : 0;

        try {
            $stmt = $this->conec->prepare("CALL sp_get_recharge_cancel_v1(:PlayerID)");
            $stmt->bindParam(':PlayerID', $PlayerID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            return "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
        }
    }

}