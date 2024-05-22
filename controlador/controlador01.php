<?php

include './modelo/modelo01.php';

class controlador001 {
    protected $consulta;
    
    public function __construct(){
        session_start();
        $this->consulta=new consultasYregistros();
        if($_REQUEST){
            if($_POST['origen'] == 'login'){
                $this->login($_POST);
            }elseif($_POST['origen'] == 'Sign_off'){
                $this->Sign_off();
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }
    }

    public function index($vista = null){
        if(isset($_SESSION['id_users']) && $_SESSION['id_users'] > 0){
            require '././vista/list_customer.php';
        }else{
            require '././vista/login.php';
        }
        
    }

    public function login($parameter){
        
        $email = $parameter['email'];
        $Password = $parameter['Password'];
        $data_user = $this->consulta->get_user($email, $Password);
        if(!empty($data_user)){
            $_SESSION['id_users'] = $data_user[0]['id_users'];
            $_SESSION['first_name'] = $data_user[0]['first_name'];
            $_SESSION['last_name'] = $data_user[0]['last_name'];
        }

        header('Location: Principal');
        exit;

    }

    public function Sign_off(){

        if(isset($_SESSION['id_users'])){
            unset($_SESSION['id_users']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
        }

        header('Location: Principal');
        exit;
    }

    public function Principal(){
        $this->index();
    }
}