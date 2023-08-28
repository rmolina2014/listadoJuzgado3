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
            <h1>Oficio de Remisíon</h1>
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
        <form >
         
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipo </label>
                <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Ejemplo:PRESCRIPCIONES" required>
              </div>
            </div>
          </div>
          
          <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label>Nº Expediente</label>
              <input type="text" id="kol2" class="form-control datepicker" placeholder="Ej: 128739" autocomplete="off" spellcheck="false">
            </div>
          </div>
          </div>

          <div class="row">
          <div class="col-sm-4">  
            <h3 class="card-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Listado de N° Autos</font></font></h3>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column" id="tabla">
                                
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
        </div>  
        <br>
        <br>
        <br>
              
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>

              <button type="button" onclick="imprimirpdf();" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Imprimir</button>
    
            </div>
          </div>
          </div>
        </div>
      
          
  <script type="text/javascript">
      
    var lista = [];
    var elInput = document.getElementById('kol2');

    elInput.addEventListener('keyup', function(e)
    {
      e.preventDefault();
      var keycode = e.keyCode || e.which;
      if (keycode == 13)
      {
         num_expediente =getIngreso($("#kol2").val());
       
         num_expediente =num_expediente.valor;

         // insertar detalles personas

           fila="<li class='nav-link' id='"+num_expediente+"'><font style='vertical-align: inherit;'>"+num_expediente+" </font><span class='badge bg-waring float-right'> <button type='button' onclick='borrar("+num_expediente+");' class='btn btn-default btn-sm'><i class='far fa-trash-alt'></i></button> </li>";

            lista.push(num_expediente);
            $('#tabla').append(fila);
          
            $("#kol2").val(''); 
      }
      });

  function borrar(id)
  {
   // borrar elemento de lista
    $('#'+ id + '').remove();
  }

  function imprimirpdf()
  {
    var vtipo= $("#tipo").val();
    window.open("imprimir.php?lista="+JSON.stringify(lista)+"&tipo="+vtipo, '_blank');
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
   