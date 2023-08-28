<?php
require '../cabecera.php';
require '../menu.php';
include("listado_comisarias.php");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado por Comisarias</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!--li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Blank Page</li-->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php

if( isset($_POST['nombre']) && !empty($_POST['nombre']) )
 {

  $objeto = new listado_comisaria();
//insertar bd
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $provincia = $_POST['provincia_id'];

  $todobien = $objecto->nuevo($nombre,$email,$provincia);
  if($todobien){
      echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
      //header('Location: listado.php');
      exit;
    } 
    else {
    ?>      
         <div class="alert alert-block alert-error fade in" style="max-width: 220px; margin: 0px auto 20px;">
         <button data-dismiss="alert" class="close" type="button">×</button>
         Lo sentimos, no se pudo guardar ...
         </div> 
    <?
    }     
}
else
{
?>
  <!-- Main content -->
  <section class="content">
 
   <div class="card card-secundary">
      
      <div class="card-header">
        <h3 class="card-title">Formulario de Ingreso </h3>
      </div>

      <div class="card-body">
    
          <div class="row">

             <div class="col-sm-6">
              <div class="form-group">
                        <label>Comisarias </label>
                        <select id="comisaria" class="form-control">
                           <option>Seleccionar ...</option>
        <?php
            $provincias = listado_comisarias::listacomisarias();
            foreach($provincias as $item)
            {
            
            ?>
            <option value="<?php echo $item['id'];?> "><?php echo $item['nombre'];?></option>
            <?
            }
        ?>
      </select>
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Nº Expediente</label>
               <input type="text" id="kol2" class="form-control datepicker" placeholder="Ej: 128739">

              </div>
            </div>
          </div>

          <div class="card">
           
            <div class="card-header">
              <h3 class="card-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Personas</font></font></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column" id="tabla">
                                
              </ul>
            </div>
            <!-- /.card-body -->
          </div>

          <div class="row" >
            <div class="col-md-8">
            <ul  class="list-group">
              
            </ul>
          </div>
        </div>
        <br>
        <br>
        <br>
              
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>

              <button type="button" onclick="guardar()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Guardar e Imprimir</button>

            </div>
          </div>
          </div>
        </div>
      </div>
 <?
 }
 ?> 
  <?php
require '../footer.html';
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
 <script type="text/javascript">

  var lista = [];

  var elInput = document.getElementById('kol2');

  elInput.addEventListener('keyup', function(e) {
  
  e.preventDefault();
  
  var keycode = e.keyCode || e.which;
  
  if (keycode == 13)
  {
     var num = $("#kol2").val(); 
     //alert(num);
        $.ajax({
          type: "POST",
          cache: false,
          async: false,
          url: 'buscardatos.php',
          data: { id: num},
          success: function(data){
            if (data)
            {
             var content = JSON.parse(data);

             for(let i = 0; i < content.length; i++) 
             {
              //alert(content);
              fila1="<a href='#' id="+content[i].persona_dni+" class='nav-link'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>"+content[i].numero_expediente+" -- "+content[i].persona+" DNI: "+content[i].persona_dni+"  "+content[i].domicilio+"</font></font><span onclick='borrar("+content[i].persona_dni+");' class='badge bg-primary float-right'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>X</font></font></span></a></li>";

              fila="<li id="+content[i].persona_dni+"><p>"+content[i].numero_expediente+" -- "+content[i].persona+" DNI: "+content[i].persona_dni+"  "+content[i].domicilio+"<span onclick='borrar("+content[i].persona_dni+");' class='badge bg-primary float-right'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>X</font></font></span></p></li>";

               $('#tabla').append(fila);
               lista.push(fila);
             }
             console.log(lista);
            
            }
             else alert('Sin Datos.');
        }
      });//fin ajax
      $("#kol2").val('');  
  }
});

function guardar()
  {
    var vcom= $("#comisaria").val(); 
    $.ajax({
           type: "POST",
           url: "imprimir.php",
           data: {lista: JSON.stringify(lista), comisaria: vcom},
           success: function(datos){
                console.log(datos);
                alert("Aviso:");
            },
           failure: function(errMsg) {
                alert("Error:"+errMsg);
           }
        });
  };

  function borrar(dni)
  {
    lista.splice(dni, 1);
    $("#"+dni+"").remove();
    console.log(lista);
    dni.parentNode.remove();
  };      
</script>

   