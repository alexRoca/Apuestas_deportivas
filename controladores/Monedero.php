<?php

class Monedero {
    protected $consulta;
    
    public function __construct(){
        session_start();
        if(isset($_SESSION['id_users']) && $_SESSION['id_users'] > 0){
            $this->consulta=new consultasYregistros();
            
            if($_POST){
                if($_POST['origen'] == 'recarga'){
                    $this->recargar($_POST);
                }elseif($_POST['origen'] == 'asignar'){
                    $this->asignar($_POST);
                }elseif($_POST['origen'] == 'anular'){
                    $this->anular($_POST);
                }elseif($_POST['origen'] == 'editar'){
                    $this->editar($_POST);
                }else{
                    $this->index($_POST);
                }
            }elseif($_GET){
                $this->index($_GET);
            }
        }else{
            header('Location: Principal');
            exit;
        }
    }

    public function index($id_customer){
        if(!empty($id_customer)){
            $parameter['PlayerID']=$id_customer['PlayerID'];
            $resultado_customer = $this->consulta->get_customer($parameter);
            $resultado_walet = $this->consulta->get_customer_wallets($parameter);
            $recharges = $this->consulta->get_recharge($parameter);
            $customer_wallets_movements = $this->consulta->get_customer_wallets_movements($parameter);
            $bank = $this->consulta->get_bank();
            $channel = $this->consulta->get_channel();
            require '././vistas/mov_monedero.php';
        }else{
            header('Location: Principal');
            exit;
        }
    }

    public function recargar($parameter){
        $parameter['id_users']=$_SESSION['id_users'];
        $this->consulta->post_recharge($parameter);

        header('Location: Monedero?PlayerID='.$parameter['id_customer']);
        exit;
    }

    public function asignar($parameter){
        $parameter['id_users']=$_SESSION['id_users'];
        $this->consulta->set_asignar($parameter);

        header('Location: Monedero?PlayerID='.$parameter['PlayerID']);
        exit;
    }

    public function anular($parameter){
        $parameter['id_users']=$_SESSION['id_users'];
        $this->consulta->set_anular($parameter);

        header('Location: Monedero?PlayerID='.$parameter['PlayerID']);
        exit;
    }

    public function editar($parameter){
        $parameter['id_users']=$_SESSION['id_users'];
        $this->consulta->set_editar($parameter);

        header('Location: Monedero?PlayerID='.$parameter['id_customer']);
        exit;
    }

}