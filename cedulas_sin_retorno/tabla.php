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
            <h1> Cedulas Sin Retorno (desde Comisarias) </h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<section class="content">
   <p>
         
          <a href="index.php" class="right btn btn-primary btn-sm" >volver</a>

          <button id="pdfout" class="right btn btn-primary btn-sm">Crear PDF</button>

        </p>
  <div class="card card-secundary">
      <div class="card-header">
        <h3 class="card-title">Listado </h3>
       
      </div>
      <div class="card-body">
         <div id="maintable">
        <h3>Tabla de Datos</h3>
    <table id="tablaDatos" class="table table-responsive ">
        <thead>
            <tr>
             <th>Datos</th>
             <!--th>N° Exp.</th>
             <th>Persona</th>
             <th>DNI</th>
             <th>Caratula</th>
             <!--th>Repartición</th-->
             <th> </th>
            </tr>
        </thead>
        <tbody>

<?php
if( isset($_GET['id']) && !empty($_GET['id']) )
{
 $id=(int)$_GET['id'];
 $datos = array();
 $listados = cedulas_sin_retorno::listadoFiltradoReparticion($id);

//print_r($listados); exit();
  $i=0;
 foreach($listados as $item)
 {
  $i++;
  ?>
     <tr>
        <td><?php echo 'Autos: '.$item['exp_autos'].' - '.utf8_encode($item['nombre']).' - Dni: '.$item['dni'].' - Domicilio: '.utf8_encode($item['domicilio']); ?></td>
      <!--td><?php echo $i; ?></td>
      <td><?php echo $item['exp_autos']; ?></td>
      <td><?php echo $item['nombre']; ?></td>
      <td><?php echo $item['dni']; ?></td>
      <td><?php echo $item['exp_caratula']; ?></td-->
      <!--td><?php echo $item['reparticion']; ?></td-->
      <td><input type="checkbox" class="eliminar"></td>
     </tr>
<?php
 }   
 }
?>
    </tbody>
    </table>
  </div>
  </div>
  </div>  
</section>    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!--    Scripts jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<!--    Scripts html2canvas-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js" integrity="sha512-sk0cNQsixYVuaLJRG0a/KRJo9KBkwTDqr+/V94YrifZ6qi8+OO3iJEoHi0LvcTVv1HaBbbIvpx+MCjOuLVnwKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

$(document).ready(function () {
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
 

var maintable = document.getElementById('maintable');
var pdfout = document.getElementById('pdfout');

pdfout.onclick = function()
{
    const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });     

    doc.margins = {
  top: 20,
  bottom: 20,
  left: 10,
  width: 522
};           

    // Definir la posición inicial para el listado
    let y = 10;

    // Función para agregar un salto de página si es necesario
    function agregarSaltoDePagina() {
      if (y >= 280) { // Cambia este valor si necesitas ajustar la posición del salto de página
        doc.addPage(); // Agregar una nueva página
        y = 10; // Reiniciar la posición vertical
      }
    }

 
    // Agregar el título del listado
    doc.setFontSize(12);
    const texto = 'Listado de Cedulas sin Retorno desde Comisarias.';
    y += 10;

    const anchoLinea = 160; // ajusta este valor según tus necesidades
    const lineas = doc.splitTextToSize(texto, anchoLinea);


    // Agregar los elementos del listado
    doc.setFontSize(12);

    // Agregar cada línea al documento con un salto de línea
    //let y = 20; // posición inicial en la página
    

    lineas.forEach((linea) => {
      doc.text(10, y, linea);
      y += 5; // ajusta este valor para controlar el espacio entre líneas
      if (y >= 290) {
        // Si la posición llega al final de la página, añadir una nueva página
        doc.addPage();
        y = 20; // reiniciar la posición en la nueva página
      }
    });

//----------------------------- renglones -----------

     y=y+5;

    $("td").each(function()
    {
        // Dividir el texto en líneas en función de un ancho de línea deseado
        const anchoLinea = 190; // ajusta este valor según tus necesidades
        const lineas = doc.splitTextToSize($(this).text(), anchoLinea);

        lineas.forEach((linea) => {
               
        //console.log($(this).text());
        //doc.text($(this).text()+'\n', 15, y);        
          doc.text(10, y, linea);
            y=y+5;
            agregarSaltoDePagina();
        });

    });

    // Guardar o mostrar el PDF
    //doc.save('listado.pdf')

    doc.output('dataurlnewwindow', {filename: 'pdf.pdf'});

};            
</script>  
<?php
require '../footer.html';
?>