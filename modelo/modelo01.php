<?php

require './conexiones/conexion.php';

class consultasYregistros extends conexion{

    public function __construct(){
        parent::__construct();
    }

    public function get_user($email, $Password){
        $sql="select t1.id_users, t1.first_name, t1.last_name from t_users t1 where t1.email='".$email."' AND t1.password=MD5('".$Password."')";
        $resultado=$this->conec->prepare($sql);
        $resultado->execute();
        $row = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

}