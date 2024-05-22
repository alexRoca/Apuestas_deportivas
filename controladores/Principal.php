<?php

class Principal {
    protected $consulta;
    
    public function __construct(){
        session_start();
        $this->consulta=new consultasYregistros();
        if($_REQUEST){
            if($_POST){
                if($_POST['origen'] == 'login'){
                    $this->login($_POST);
                }elseif($_POST['origen'] == 'Sign_off'){
                    $this->Sign_off();
                }else{
                    $this->index();
                }
            }elseif($_GET){
                $this->get_customer($_GET);
            }
        }else{
            $this->index();
        }
    }

    public function index($vista = null){
        if(isset($_SESSION['id_users']) && $_SESSION['id_users'] > 0){
            $this->get_customer();
        }else{
            require '././vistas/login.php';
        }
    }

    public function login($parameter){
        $data_user = $this->consulta->get_user($parameter);

        if(!empty($data_user)){
            $_SESSION['id_users'] = $data_user[0]['id_users'];
            $_SESSION['first_name'] = $data_user[0]['first_name'];
            $_SESSION['last_name'] = $data_user[0]['last_name'];
        }
        $this->index();
    }

    public function Sign_off(){
        if(isset($_SESSION['id_users'])){
            unset($_SESSION['id_users']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
        }
        $this->index();
    }

    public function get_customer($parameter = NULL){
        $parameter['PlayerID'] = !empty($parameter['PlayerID']) ? $parameter['PlayerID'] : '';
        $parameter['document'] = !empty($parameter['document']) ? $parameter['document'] : '';
        $parameter['first_name'] = !empty($parameter['first_name']) ? $parameter['first_name'] : '';
        $parameter['last_name'] = !empty($parameter['last_name']) ? $parameter['last_name'] : '';

        $data_customer = $this->consulta->get_customer($parameter);
        require '././vistas/list_customer.php';
    }
}