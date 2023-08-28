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
          <h1>Listado de Notas para Comisarias</h1>
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
  $id_listado_comisaria=$_GET['id'];
?>
  <!-- Main content -->
  <section class="content">
   <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Formulario de Ingreso de Personas por N° de Expediente. </h3>
      </div>
      <div class="card-body">
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
        </div>
      </div>

 <script type="text/javascript">
  var listado_comisaria_id=<?php echo $id_listado_comisaria;?>;
  var lista = [];
  var elInput = document.getElementById('kol2');
  elInput.addEventListener('keyup', function(e) {
  e.preventDefault();
  var keycode = e.keyCode || e.which;
  if (keycode == 13)
  {
     num_expediente =getIngreso($("#kol2").val());
   
     num_expediente =num_expediente.valor;

     // insertar detalles personas

      $.ajax({
          type: "POST",
          cache: false,
          async: false,
          url: 'insertarDetalle.php',
          data: { num_expediente: num_expediente,listado_comisaria_id: listado_comisaria_id },
          success: function(data)
          {
            if (data)
            {
              console.log(data);
            }
          }
          });//fin ajax

        mostrarDetalle(listado_comisaria_id);
        $("#kol2").val(''); 
        }
      });

  function mostrarDetalle(id)
  {
    $('#tabla').empty();
    $.ajax({
           type: "POST",
           url: "mostrarDetalle.php",
           data: {id: id},
           success: function(datos)
           {
            //console.log(datos);
            //alert("Aviso:");
            var content = JSON.parse(datos);
            for(let i = 0; i < content.length; i++) 
            {
              //alert(content);
              fila="<li class='nav-link'><font style='vertical-align: inherit;'>"+content[i].orden+" ) "+content[i].numero_expediente+" -- "+content[i].persona+" DNI: "+content[i].persona_dni+"  "+content[i].domicilio+" -- "+content[i].rol+" -- "+content[i].estado_actuacion+" </font><span class='badge bg-waring float-right'> <button type='button' onclick='borrar("+content[i].id+");' class='btn btn-default btn-sm'><i class='far fa-trash-alt'></i></button> </li>";
               $('#tabla').append(fila);
             }

            },
           failure: function(errMsg) {
                alert("Error:"+errMsg);
           }
        });
  }  

 function guardar()
 {
    $('#tabla').empty();
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
  }

  function borrar(id)
  {
    $('#tabla').empty();
    $.ajax({
           type: "POST",
           url: "borrarPersonaDetalle.php",
           data: {id: id},
           success: function(datos){
                console.log(datos);
                //alert("Aviso:");
            },
           failure: function(errMsg) {
                alert("Error borrarPersonaDetalle.php :"+errMsg);
           }
        });
     mostrarDetalle(listado_comisaria_id);
  }

  function imprimirpdf()
  {
    window.open("imprimir.php?id="+listado_comisaria_id , '_blank');
    //window.location.replace("index.php");
    window.location="index.php";
  }

  /* ----- FUNCIONES PARA INGRESO DESDE LECTOR DE BARRA O TECLADO ----- */

/*  Para obtener un ingreso a partir de teclado o lector de barras
  Retorna un objeto con el tipo de ingreso y numero ingresado. Los tipo son:
    0: Numero de expediente ingresado por escaner
    1: Numero de cedula ingresado por escaner
    2: Numero de escrito ingresado por escaner
    9: Numero de expediente ingresado manualmente
*/
function getIngreso(param){
  valor=param.replace(/^\s+/g,'').replace(/\s+$/g,'');
  if(parseInt(valor)&&(valor.length==13)){/* Ingreso por lector de barras */
    Juzgado=valor.substring(0,1);if(Juzgado!="3"){alert("El código pertenece a otro juzgado!");return 0;}/* Control del juzgado propietario del expediente */
    Version=valor.substring(1,3);
    switch(Version){/* Control de versión de código de barras */
      case "00":{
        Operacion=valor.substring(3,5);/* Chequeo la de-codificación de operaciones soportadas */
        switch(Operacion){
          case "00":result={tipo:"0",valor:parseInt(valor.substring(5,12))};return result;/* Número de expediente */
          case "01":result={tipo:"1",valor:parseInt(valor.substring(5,12))};return result;/* Identificador de cédula */
          default:alert("Operacion no soportada! Codigo="+Operacion);return 0;
        }
      }break;
      case "01":{
        Operacion=valor.substring(3,5);/* Chequeo la de-codificación de operaciones soportadas */
        switch(Operacion){
          case "00":result={tipo:"0",valor:parseInt(valor.substring(5,12))};return result;/* Número de expediente */
          case "01":result={tipo:"2",valor:parseInt(valor.substring(5,12))};return result;/* Identificador de escrito */
          default:alert("Operacion no soportada! Codigo="+Operacion);return 0;
        }
      }break;
      default: alert("Versión de código no soportada!");return 0;break;
    }
  }else{
    result={tipo:"9",valor:valor.split("+").join("_")};return result;
  }
}

</script>
<?php
require '../footer.html';
?>
   