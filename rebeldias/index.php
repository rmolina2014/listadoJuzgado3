<?php
require '../cabecera.php';
require '../menu.php';
include("../listado_comisarias/listado_comisarias.php");
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
        <h3 class="card-title">Formulario de Busqueda</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="buscardatos_dni.php" >
         
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>DNI: </label>
                <input type="number" name="dni" id="dni" class="form-control" required autofocus >
              </div>
            </div>
          </div>

         <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
          </div>
          </div>

        </form>
    </div>
    </div>
  </section> 
</div>  
<?php
require '../footer.html';
?>   