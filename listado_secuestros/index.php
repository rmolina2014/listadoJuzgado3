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

    <!--p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nueva Nota </a> </p-->

    <table id="listado" class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>Autos</th>
          <th>Objetos</th>
          <th>Cantidad</th>
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
              <td><?php echo $item['objeto']; ?></td>
              <td><?php echo $item['cantidad']; ?></td>
              <td><?php echo $item['descripcion']; ?></td>
              <td><?php echo $item['ubicacion']; ?></td>
              <td>
                <div style="margin: 0; border=0;">
<a class="btn btn-primary btn-sm" href="imprimir_restitucion.php?id=<?php echo $item['sucuestro_id']; ?>" target="_blank">RESTITUCIÓN</a>

                <a class="btn btn-primary btn-sm" href="imprimir_donacion.php?id=<?php echo $item['sucuestro_id']; ?>" target="_blank">DONACIÓN</a>

                </div>
                


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
<?php
require '../footer.html';
?>