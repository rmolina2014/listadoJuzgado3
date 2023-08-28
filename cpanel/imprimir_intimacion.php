<?php
require '../cabecera.php';
require '../menu.php';
include("cpanel.php");
?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Panel de Control</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php
if( isset($_GET['per_id']) && !empty($_GET['per_id']) )
{
  $objeto = new cpanel();
  //insertar bd
  $persona_id = $_GET['per_id'];
  $listado_requerimiento_id = $_GET['req_id'];
  $fecha =date("Y-m-d");
  /*$fecha_creacion=date("Y-m-d");
  $estado="Edicion";
  $usuario="$NOMBRE_USUARIO";
  $contenido=$_POST['contenido'];
  $tipo="Libre";*/

 $datos = $objeto->obtenerDatosPersona($persona_id);
 foreach($datos as $item)
 {
   $nombre=$item['nombre']; 
   $dni=$item['numero_documento']; 
   $domicilio=$item['domicilio'];
   $numero_expediente="numero_expediente";
   $caratula="caratula";
  } 
 
 ?>
  <!-- Main content -->
  <section class="content">
    <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Formulario de Intimación </h3>
      </div>
      <div class="card-body">
        <form id="form">
          <input type="hidden" id="<?php echo $listado_requerimiento_id; ?>">
          <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <label>Destinatario : <?php echo $nombre; ?> </label>
                <br>
                 <label>D.N.I. : <?php echo $dni; ?> </label>
                <br>
                  <label>Domicilio : <?php echo $domicilio; ?> </label>
               
              </div>
            </div>
          </div>

          <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <label>Contenido de la Intimación :</label>
                <textarea name="contenido" id="contenido" class="form-control" required></textarea>
              </div>
             </div>   
          </div> 
        <br>
        <br>
        <br>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
              <button type="button" onclick="imprimirpdf();" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Guardar e Imprimir</button>
            </div>
          </div>
          </div>
        </form>
     </div>
  </div>
  <?php
   }
   ?>
 <script type="text/javascript">
  
  function imprimirpdf()
  {
    
    var v_con= $("#contenido").val(); 
    var v_req=<?php echo $_GET['req_id'];?>// $("#req_id").val(); 

    // actualizar la tabla de requerimientos con la intimacion
    
    $.post("actualizar_requerimiento.php",
    {
      contenido:v_con,
      id_req: v_req
    },
    function(data){
      alert("Data: " + data );
    }); 

    // abrir el pdf
    window.open("imprimir.php?contenido="+v_con+"&req_id="+v_req,'_blank');
    //window.location.replace("index.php");
    window.location="index.php";
  }

  

</script>
<?php
require '../footer.html';
?>
   
