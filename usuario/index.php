<?php
require '../cabecera.php';
require '../menu.php';
include("usuario.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
   

    <p> <a class="btn btn-primary" href="">Adicionar Nuevo</a> </p>

    <table id="listado" class="table table-striped table-bordered table-hover table-condensed" >
          <thead>
             <tr>
             <th>Nº</th>
             <th>Usuario</th>
             <th>Nombre </th>
             <th>Permiso </th>
             <th>Funciones</th>
             </tr>
           <thead>
           <tbody>
          <?php
          $objecto = new Usuario();
          $usuarios = usuario::lista();
          foreach($usuarios as $item)
          {
          ?>
           <tr>
              <td><?php echo $item ['id']; ?></td>
              <td><?php echo $item ['usuario']; ?></td>
              <td><?php echo $item ['nombrereal']; ?></td>
            
              <td>
                <?php
                      switch ($item ['nivel'])
                      {
                        case '1':
                          echo 'Administrador';
                          break;
                        case '2':
                          echo 'Empresa';
                          break;  
                      }
                      ?>
              </td>
              <td>
                  <a class="btn btn-primary btn-sm" href="editar1.php?id=<?php echo $item ['id'];?>">Editar</a>
                  <a class="btn btn-danger btn-sm" href="" id="borrar1<?php echo $item ['id'];?>" > Borrar</a>
              </td>
          </tr>
          <?php
           }
          ?>
          </tbody>
         </table>
         </div>
         </div>
  </div>
 </div>
 </div>  

  <script src="../js/jquery-1.10.2.js"></script>
  <script src="../js/bootstrap.min.js" type="text/javascript"></script>

  <script type="text/javascript">
 $(document).ready(function()
  {
     // llamada ajax
      $('#agregar').click(function(){
        $.ajax({
            url: 'nuevo.php',
            success: function(data) {
                $('#div_dinamico').html(data);
            }
        });
    });

    //editar
    $("a[id^='editar']").click(function(evento)
       {
        evento.preventDefault();
        vid = this.id.substr(6,4);
        $.ajax({
          type: "POST",
          cache: false,
          async: false,
          url: 'editar.php',
          data: { id: vid},
          success: function(data){

            if (data)
            {
             //$('#div_dinamico').hide();
             $('#div_dinamico').html(data);
            }
        }
        })//fin ajax
        });//fin

    //eliminar
     $("a[id^='borrar']").click(function(evento)
       {
        evento.preventDefault();
        vid = this.id.substr(6,4);
        $.ajax({
          type: "POST",
          cache: false,
          async: false,
          url: 'eliminar.php',
          data: { id: vid},
          success: function(data){
            if (data)
            {
              alert(data);
               location.reload(true);
            }
        }
        })//fin ajax
        });//fin


 });
</script>
</body>
</html>