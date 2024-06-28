<?php
require '../cabecera.php';
require '../menu.php';
include("../listado_secuestros/listado_secuestros.php");
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Listado de Secuestros</h1>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <br>
    <div id="formulario" >
    
    <form action="agregar_secuestros.php" method="POST">
      <input type="hidden" id="caja_valor" name="caja_valor" id="caja_valor">
      <button type="submit" class="btn btn-primary" id="enviar"> Seleccionar Elementos </button>
    </form>
    </div>
    <br>

    <!--p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nueva Nota </a> </p-->
    <!--button type="button" class="btn btn-primary" onclick="sendToPHP()">Seleccionar</button-->
    <table id="listado" class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>Autos</th>
          <th>Caratula</th>
          <th>Cantidad</th>
          <th>Objetos</th>
          <th>Descripcion</th>
          <th>Ubicacion</th>
          <th>Imprimir</th>
        </tr>
        <thead>
        <tbody>
          <?php
          $objeto = new listado_secuestros();
          $listados = $objeto->lista();
          foreach ($listados as $item) {
          ?>
            <tr>
              <input type="hidden" id="<?php echo $item['sucuestro_id']; ?>">
              <td><?php echo $item['autos']; ?></td>
              <td><?php echo $item['caratula']; ?></td>
              <td><?php echo $item['cantidad']; ?></td>
              <td><?php echo $item['objeto']; ?></td>
              <td><?php echo $item['descripcion']; ?></td>
              <td><?php echo $item['ubicacion']; ?></td>
              <td>
                <input type="checkbox" onclick="addToList(<?php echo $item['sucuestro_id']; ?>)" id="checkbox<?php echo $item['sucuestro_id']; ?>" value="valor1">
              </td>
            </tr>
          <?php
          }
         ?>
    
        </tbody>
    </table>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
 
  let list = [];

  const boton=document.getElementById("enviar"); 
  boton.disabled = true;

  //$('#enviar').attr('disabled', false);
   

  // funcion para habilitar o desabilitar un boton si la lista no esta vacia
  function habilitarBoton() {
    
    if (list.length > 0) {
      boton.disabled = false;
    } else {
      boton.disabled =true;
    }
  }
   
  function addToList(value) {
    if (list.includes(value)) {
      list = list.filter(item => item !== value);
      document.getElementById("caja_valor").value = JSON.stringify(list);
      habilitarBoton();
    } else {
      list.push(value);
      document.getElementById("caja_valor").value = JSON.stringify(list);
      habilitarBoton();
    }
    console.log(list);
  }
  
</script>
<?php
require '../footer.html';
?>