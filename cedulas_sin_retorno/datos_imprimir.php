<?php
require '../cabecera.php';
require '../menu.php';
include("cedulas_sin_retorno.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Cedulas Sin Retorno desde Comisarias. </h1>
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
        <h3 class="card-title">Formulario de Ingreso </h3>
      </div>
      <div class="card-body">
        <form id="form" enctype="multipart/form-data" method="post" action="nuevo.php">
          <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <label>Comisarias - Reparticiones </label>
                  <select id="comisaria" name="destino" class="form-control">
                  <option>Seleccionar ...</option>
                  <?php
                      $provincias = cedulas_sin_retorno::listacomisarias();
                      foreach($provincias as $item)
                      {
                      
                      ?>
                      <option value="<?php echo $item['id'];?> "><?php echo $item['nombre'];?></option>
                      <?php
                      }

                  ?>
                  <!--option value="POLICÍA DE SAN JUAN ">POLICÍA DE SAN JUAN</option-->
                  </select>
              </div>
            </div>
          </div>
        
        </form>
     </div>
  </div>
</section>
<!-- segundo content para el listado-->
<section class="content">
  <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Listado </h3>
      </div>
      <div class="card-body">
        <h1>Tabla de Datos</h1>
    <table id="tabla-datos" class="table-responsive">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Domicilio</th>
                <th>DNI</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los datos dinámicamente -->
        </tbody>
    </table>
      </div>
  </div>  
</section>    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  $(document).ready(function () {


  $('#comisaria').change(function (){


    var id=$('#comisaria').val();
     //$('#tabla-datos').empty();

    document.location.href = "tabla.php?id="+id;
    
    // Cargar datos desde el archivo datos.php
    /*
    $.ajax({
        data:{id:id},
        url: 'tablarrrr.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {

            if (data && data.length > 0) {
                var tabla = $('#tabla-datos tbody');
                $.each(data, function (index, item) {
                    // Crear una fila por cada elemento en el JSON
                    var fila = $('<tr>');
                    fila.append('<td>' + item.nombre + '</td>');
                    fila.append('<td>' + item.domicilio + '</td>');
                    fila.append('<td>' + item.dni + '</td>');
                    // Agregar una casilla de verificación para eliminar
                    fila.append('<td><input type="checkbox" class="eliminar"></td>');
                    tabla.append(fila);
                });
            } else {
                alert('No se encontraron datos.');
            }
                
            console.log(data); 
          var content = JSON.parse(data);
            for(let i = 0; i < content.length; i++) 
            {
              //alert(content);
              fila="<li class='nav-link'><font style='vertical-align: inherit;'>"+content[i].orden+" ) "+content[i].numero_expediente+" -- "+content[i].persona+" DNI: "+content[i].persona_dni+"  "+content[i].domicilio+" -- "+content[i].rol+" -- "+content[i].estado_actuacion+" </font><span class='badge bg-waring float-right'> <button type='button' onclick='borrar("+content[i].id+");' class='btn btn-default btn-sm'><i class='far fa-trash-alt'></i></button> </li>";
               $('#tabla').append(fila);
             }
        },
        error: function () {
            alert('Error al cargar los datos desde datos.php');
        }
    });*/

       });
    
     // Manejar el evento de clic en la casilla de verificación de eliminar
    $(document).on('click', '.eliminar', function () {
        var id = $(this).data('id');
        // Aquí puedes agregar el código para eliminar la fila del servidor si es necesario
        // Por ejemplo, puedes hacer otra solicitud AJAX a un archivo "eliminar.php"
        // para eliminar el registro correspondiente en la base de datos.
        // Luego, puedes eliminar la fila de la tabla en función de la respuesta del servidor.
        // Si prefieres, puedo proporcionar un ejemplo de cómo hacer esto.
        $(this).closest('tr').remove();
    });
});

 
</script>  
<?php
require '../footer.html';
?>
 
