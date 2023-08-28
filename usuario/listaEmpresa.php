<?
include("../oferta/oferta.php");

  $items = oferta::listaEmpresa();
  $datos = array(); //creamos un array
  foreach($items as $item)
  {
  $id=$item['id'];
  $nombre=$item['nombre'];
  $datos[] = array('id'=> $id, 'nombre'=> $nombre);
  }
  //Creamos el JSON
  header('Content-type: application/json; charset=utf-8');
  $json_string = json_encode($datos);
  echo $json_string;
?>