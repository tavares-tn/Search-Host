<?php

include_once '../Rede.class.php';
include_once '../Banco.class.php';

$hosts = $_POST['selecionaRede'];
$rede = explode("/", $hosts);

$obj = new Rede();
$ip = $rede[0];
$tam= $obj->tamanhoRede($rede[1]);

$retorno = array();


if ($obj->tamanhoRede($rede[1]) < 16) {
   $retorno = $obj->scanTres($ip, $tam);
} else {
    if ($obj->tamanhoRede($rede[1]) < 24) {
     $retorno =   $obj->scanDois($ip, $tam);
    } else {
      $retorno =  $obj->scanUm($ip, '200');
    }
}

//print_r($retorno);

$quant = count($retorno);

$db = new Banco();
$db->conectaBanco();

$db->insertRede($hosts,date("d/m/y H:i")); 
$id = $db->ultimaRede();

//print_r($retorno);

   $db->insertRede($hosts,date("d/m/y H:i"));
for($i=0; $i<($quant / 3);$i++){ 
///    echo $retorno[$i].'  '.$retorno[$i+($quant/3)].' '.$retorno[$i+(($quant/3)*2)].'<br>';
$db->insertDispositivo($retorno[$i], $retorno[($i+($quant/3))], $fab, $retorno[($i + (($quant/3)*2))], $id);
}


//
header('Location: ./dispositivos.php');


?>