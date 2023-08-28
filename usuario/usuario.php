<?php
include_once("bd/conexion.php");
class Usuario
{
  public function obtenerUsuario($usuario)
  {
   $consulta="SELECT * FROM usuarios where dni='$usuario'";
    
    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
      return $data;
    }else return $rs;
  }
  
  public static function lista()
  {
    $consulta="SELECT *             
                FROM
                    `usuario`;";

    $rs = mysqli_query(conexion::obtenerInstancia(), $consulta);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
    }
    return $data;
  }



   public function nuevo($usuario,$password,$nombrereal,$nivel)
    {
     
    $sql="INSERT INTO `usuario`
            (`usuario`,
             `password`,
             `nombrereal`,
             `nivel`)
VALUES ('$usuario',
        '$password',
        '$nombrereal',
        '$nivel');";
      $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
    return $rs;
  }


  public function editar($id,$usuario,$nivel,$nombrereal)
  {
     
      $sql="UPDATE `usuario`
            SET `usuario` = '$usuario',
                `nombrereal` = '$nombrereal',`nivel` = '$nivel'
            WHERE `id` = '$id'";
    $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
    return $rs;
    }

    public function cambiarpass($id,$password)
  {
     
      $sql="UPDATE `usuario`
            SET `password` = '$password',
                WHERE `id` = '$id'";
    $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
    return $rs;
    }

   public function obtenerId($id)
   {
   $sql="SELECT * FROM `usuario` where id='$id'";
    $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
    if(mysqli_num_rows($rs) >0)
    {
      while($fila = mysqli_fetch_assoc($rs))
      {
        $data[] = $fila;
      }
    }
    return $data;
    }

    public function eliminar($id)
    {
     $sql="DELETE FROM `usuario` WHERE id ='$id'";
     $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
     return $rs;
    }

     public function listaEmpresa()
     {
      $sql="SELECT * FROM empresa";
      
      $rs = mysqli_query(conexion::obtenerInstancia(), $sql);
      if(mysqli_num_rows($rs) >0)
      {
        while($fila = mysqli_fetch_assoc($rs))
        {
          $data[] = $fila;
        }
      }
      return $data;
    }  

}
?>