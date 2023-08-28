<?php
include_once("bd/conexion.php");
include("usuario/usuario.php");
if ($_POST['usuario'])
 {
   $usuario = $_POST['usuario'];
   $password =$_POST['password'];
   $objecto = new Usuario();
   $usuarios = $objecto->obtenerUsuario($usuario);
   if ($usuarios)
    {  
      
     foreach($usuarios as $item)
     {             
    

if (password_verify($password,$item['pass'])) 
           {
            // crear sesion y guardar datos
            session_name("sesion_sj2021");
            // incia sessiones
            session_start();
            $_SESSION['sesion_usuario'] = $item['login'];
            $usuario_id=$_SESSION['sesion_id'] = $item['id'];
            $_SESSION['sesion_nombre'] = $item['nombre'];
            $_SESSION['sesion_permisos'] = $item['grupo'];
            //$_SESSION['sesion_empresa'] = $item['empresa_id'];
             
            // registro el usuario 
            /*$fecha = date("Y-m-d");
            $hora = date("H:i:s");
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
              {
                $ip=$_SERVER['HTTP_CLIENT_IP'];
              }
              elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
              {
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
              }
              else
              {
                $ip=$_SERVER['REMOTE_ADDR'];
              }

             $sql2 = "INSERT INTO login (usuario_id,fecha,hora,ip) VALUES ('$usuario_id', '$fecha', '$hora', '$ip')";
             $rs= mysqli_query($objCon,$sql2);
*/
            //preguntar por grupo permiso 1 ver todos los documentos, 2 solos el area
            
           
               echo "<script language=Javascript> location.href=\"cpanel/index.php\"; </script>";
             exit();
           
             }//fin if paswword
             else
              {
                echo '<script> alert("Clave Incorrecta."); window.location="index.html"; </script>';//Password incorrecto';
                exit();
              }
          }//fin del forech
        }
        echo '<script> alert("Usuario Incorrecto."); window.location="index.html";</script>';//Password incorrecto';
        exit();

}
 echo '<script> alert("Datos Incorrecto final."); window.location="index.html";</script>';//Password incorrecto';
          ?>
              