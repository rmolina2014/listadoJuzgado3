<?php
 session_name("sesion_sj2021");
 session_start();
 if (isset($_SESSION['sesion_usuario']))
 {
   $USUARIO_ID= $_SESSION['sesion_id'];
   $USUARIO=$_SESSION['sesion_usuario'];
   $NOMBRE_USUARIO=$_SESSION['sesion_nombre'];
   $PERMISO=$_SESSION['sesion_permisos'];
 }
 else { header ("Location:index.php"); }
 ?>