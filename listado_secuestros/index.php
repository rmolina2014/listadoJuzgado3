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
    
    <form action="validarLista.php" method="POST">
      <input type="text" name="caja_valor" id="caja_valor">
      <input type="submit" value="Seleccionar Elementos" class="btn btn-primary">
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
                <!--div style="margin: 0; border:0;">

                  <a class="btn btn-primary btn-sm" href="imprimir.php?id=<?php echo $item['sucuestro_id']; ?>">prueba STITUCIÓN</a>
                  <a class="btn btn-primary btn-sm" href="imprimir_restitucion.php?id=<?php echo $item['sucuestro_id']; ?>" target="_blank">RESTITUCIÓN</a>

                  <a class="btn btn-primary btn-sm" href="imprimir_donacion.php?id=<?php echo $item['sucuestro_id']; ?>" target="_blank">DONACIÓN</a>

                </div-->

                <!--div class="form-check form-check-inline">
                  <input class="form-check-input" id="dest<?php echo $item['sucuestro_id']; ?>" name="<?php echo $item['sucuestro_id']; ?>" type="radio" value="dest<?php echo $item['sucuestro_id']; ?>">
                  <label class="form-check-label" for="inlineRadio2">1-DESTRUCCIÓN </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" id="dona<?php echo $item['sucuestro_id']; ?>" name="rad<?php echo $item['sucuestro_id']; ?>" type="radio" value="dona<?php echo $item['sucuestro_id']; ?>">
                  <label class="form-check-label" for="inlineRadio2">2-DONACIÓN </label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" id="rest<?php echo $item['sucuestro_id']; ?>" name="rad<?php echo $item['sucuestro_id']; ?>" type="radio" value="rest<?php echo $item['sucuestro_id']; ?>">
                  <label class="form-check-label" for="inlineRadio1">3-RESTITUCIÓN</label>
                </div-->


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
  //var lista = [];

  /*function agregar(id) {
    lista.push(id);
    console.log(lista);
  }

  function enviarLista() {
    $.ajax({
      url: 'validarLista.php',
      type: 'POST',
      data: {
        list: lista
      },
      success: function(response) {
        console.log(response);
      },
      error: function(error) {
        console.log(error);
      }
    });
  }*/

  let list = [];

  function addToList(value) {
    if (list.includes(value)) {
      list = list.filter(item => item !== value);
    } else {
      list.push(value);
      document.getElementById("caja_valor").value = JSON.stringify(list);

    }
    console.log(list);
  }

  function sendToPHP() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "validarLista.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        console.log(this.responseText);
      }
    };
    xhr.send("list=" + JSON.stringify(list));
  }
</script>
<?php

require '../footer.html';
?>