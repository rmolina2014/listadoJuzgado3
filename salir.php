<?php
session_start();
unset($_SESSION['sesion_usuario']);
unset($_SESSION['sesion_id']);
session_destroy();
header('Location:index.html');
?>