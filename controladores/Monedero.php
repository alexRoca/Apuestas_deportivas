<?php

class Monedero {
    protected $consulta;
    
    public function __construct(){
        session_start();
        if(isset($_SESSION['id_users']) && $_SESSION['id_users'] > 0){
            $this->consulta=new consultasYregistros();
            $this->index($_GET);
        }else{
            header('Location: Principal');
            exit;
        }
    }

    public function index($id_customer){
        if(!empty($id_customer)){
            $parameter['PlayerID']=$id_customer['PlayerID'];
            $resultado = $this->consulta->get_customer($parameter);
            require '././vistas/mov_monedero.php';
        }else{
            header('Location: Principal');
            exit;
        }
    }
}