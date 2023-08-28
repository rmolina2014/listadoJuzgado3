<?php
include("cpanel.php");
$objeto = new cpanel();
$id_req=(int)$_POST['id_req'];
$contenido=$_POST['contenido'];
$fecha=date("Y-m-d");
$datos = $objeto->actualizarRequerimiento($id_req,$contenido,$fecha);


?>

