<?php
require '../cabecera.php';
require '../menu.php';
include("rebeldias.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consulta de Rebeldias</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

     <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Datos</h3>
      </div>
      <div class="card-body">
        <table class="table">
        <thead>
        <tr>
          <th scope="col">Apellido Nombre</th>
          <th scope="col">DNI</th>
          <th scope="col">Domicilio</th>
        </tr>
        </thead>
        <tbody>
        <?php
      if( isset($_POST['dni']) && !empty($_POST['dni']) )
      {
       $id=(int)$_POST['dni'];
       $objeto = new rebeldias();
       $total=0;
       $datos = $objeto->buscardatos_dni($id);
       foreach($datos as $item)
       {
        $persona=$item['apellido'].' '.$item['nombre']; 
        $domicilio=$item['domicilio']; 
        $domicilio_legal=$item['domicilio'];
        $persona_dni=$item['numero_documento'];
        ?>

          <tr>
            <td><?php echo $persona; ?> </td>
            <td><?php echo $persona_dni  ; ?> </td>
            <td><?php echo $domicilio_legal; ?> </td>
          
          </tr>
       <?php 
        }
       ?>  
        </tbody>
      </table>
    </div>  
  </div>  
<!-- Main content -->
<section class="content">

<div class="card card-secundary">
 <div class="card-header">
   <h3 class="card-title">Actuaciones</h3>
 </div>
 <div class="card-body">

   <table class="table">
    <thead>
    <tr>
     <th scope="col">Actuación Estado</th>
     <th scope="col">Actuación Rol</th>
     <th scope="col">expedientes_autos</th>
     <th scope="col">expedientes_caratula</th>
     <th scope="col">expediente_descripcion</th>
     <th scope="col">tipo_expediente</th>
     <th scope="col">estado_expediente</th>
     <th></th>
    </tr>
    </thead>
    <tbody>
      <?php
      $datos = $objeto->buscar_actuaciones_dni($id);
      foreach($datos as $item)
      {
      $actuaciones_estado=$item['actuaciones_estado']; 
      $actuaciones_rol=$item['actuaciones_rol']; 
      $expedientes_autos=$item['expedientes_autos'];
      $expedientes_caratula=$item['expedientes_caratula'];
      $expediente_descripcion=$item['expediente_descripcion'];
      $tipo_expediente=$item['tipo_expediente'];
      $estado_expediente=$item['estado_expediente'];
      ?>
        <tr>
          <td><?php  echo $actuaciones_estado; ?> </td>
          <td><?php  echo $actuaciones_rol  ; ?> </td>
          <td><?php  echo $expedientes_autos; ?> </td>
          <td><?php  echo $expedientes_caratula; ?> </td>
          <td><?php  echo $expediente_descripcion; ?> </td>
          <td><?php  echo $tipo_expediente; ?> </td>
          <td><?php  echo $estado_expediente; ?> </td>
          <td> <button class="btn btn-primary" type="button">Imprimir</button> </td>

        </tr>
       <?php 
        }
     } // if del post
    ?>
      
     </tbody>
  </table>
</div>
</div>
</section>
</div>  
<?php
require '../footer.html';
?>    
