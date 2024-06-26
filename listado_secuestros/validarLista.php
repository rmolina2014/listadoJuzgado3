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
        <h5>Elementos de Secuestros</h5>
        <ul class="list-group">
            <?php
            $list = json_decode($_POST['caja_valor']);
            /*echo "<pre>";
            print_r($list);
            var_dump($list);
            echo "</pre>";
            */
            foreach ($list as $item) {
                //echo $item . "\n";
                $objeto = new listado_secuestros();
                $listados = $objeto->obtenerDatosSecuestros($item);
                foreach ($listados as $item) {
            ?>
                    <li class="list-group-item">
                        <?php echo $item['autos'] . '-' . $item['caratula'] . '-' . $item['objeto'] . ' - ' . $item['descripcion']; ?>
                    </li>
            <?php
                }
            }
            ?>
        </ul>

        <h1>Lista de Autos</h1>
        <div id="tabla-autos"></div>

        <table id="tabla-datos1">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Autos</th>
                    <th>Caratula</th>
                    <th>Objeto</th>
                    <th>Descripción</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <h5>Acciones</h5>
        <div class="d-grid gap-2 d-md-block">
            <form action="imprimir_donacion.php" method="POST" target="_blank">
                <input type="hidden" name="donacion" id="donacion">
                <input type="submit" value="Donacion">
            </form>

            <form action="imprimir_Restitucion.php" method="POST">
                <input type="hidden" name="restitucion" id="restitucion">
                <input type="submit" value="Restitucion">
            </form>

            <form action="imprimir_Destruccion.php" method="POST">
                <input type="hidden" name="destruccion" id="destruccion">
                <input type="submit" value="Destruccion">
            </form>

        </div>

        <script>
            /*
            document.getElementById("donacion").value = JSON.stringify(<?php echo $_POST['caja_valor']; ?>);
            document.getElementById("restitucion").value = JSON.stringify(<?php echo $_POST['caja_valor']; ?>);
            document.getElementById("destruccion").value = JSON.stringify(<?php echo $_POST['caja_valor'];; ?>);


            let nuevaLista = [];
            nuevaLista = <?php echo $_POST['caja_valor']; ?>;
            console.log(nuevaLista);

            // Recorre el array y crea la tabla
            $.each(nuevaLista, function(index, numero) {
                var fila = $("<tr>");
                fila.append("<td>" + numero + "</td>");

                // Crea el botón de eliminar con un identificador único
                var botonEliminar = $("<button>", {
                    id: "eliminar-" + index,
                    text: "Eliminar"
                });

                // Agrega un evento click al botón para eliminar la fila
                botonEliminar.click(function() {
                    $(this).parent().remove(); // Elimina la fila padre
                });

                fila.append("<td>").append(botonEliminar); // Agrega el botón a la fila
                $("#tabla-datos tbody").append(fila); // Agrega la fila a la tabla
            });
            */
            $(document).ready(function(){
            $("#btn-cargar").click(function(){
                cargarAutos();
            });
        });

        function cargarAutos(){
            var listaNumeros = <?php echo $_POST['caja_valor']; ?>;//[1, 2, 3, 4, 5]; // Ejemplo de lista de números
            
            $.ajax({
                url: "json_lista_secuestros.php", // Cambiar por la URL de tu archivo PHP
                type: "POST",
                data: { listaNumeros: listaNumeros }, // Enviar la lista de números al servidor
                dataType: "json",
                success: function(data){
                    if(data.length > 0){
                        generarTabla(data);
                        console.log(data);
                    }else{
                        alert("No hay datos disponibles");
                    }
                },
                error: function(error){
                    console.error("Error:", error);
                }
            });
        }

        function generarTabla(datos){
            var html = "";
            html += '<table class="table table-striped">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Auto</th>';
            html += '<th>Caratula</th>';
            html += '<th>Fecha</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for(var i = 0; i < datos.length; i++){
                html += '<tr>';
                html += '<td>' + datos[i].auto + '</td>';
                html += '<td>' + datos[i].caratula + '</td>';
                html += '<td>' + datos[i].fecha + '</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';

            $("#tabla-datos").html(html);
        }
        </script>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require '../footer.php';
?>