<?php

include './modelos/modelo01.php';
include './controladores/Principal.php';
include './controladores/Monedero.php';

$scriptName = $_SERVER['SCRIPT_NAME'];
$scriptDir = dirname($scriptName);
$urlCompleta = $_SERVER['REQUEST_URI'];
$clase = str_replace($scriptDir, '', $urlCompleta);

if($clase == '/'){
    header('Location: Principal');
}

$clase_parametros = explode("?", $clase);

$clase_metodo = explode("/", $clase_parametros[0]);

$new_clase =$clase_metodo[1];

$controlador0001 = new $new_clase();
