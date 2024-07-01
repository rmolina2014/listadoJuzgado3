<?php
require '../cabecera.php';
require '../menu.php';
include("listado_secuestros.php");
$listado_elementos = $_POST['caja_valor'];
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
        <div class="row">
            <div class="col-md-12" style="padding: 15px;">
                <h5>Elementos</h5>
                <div id="tabla-datos"></div>

                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Datos</h3>
                    </div>


                    <form action="imprimir_donacion.php" method="POST" target="_blank">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nombre">Destinatario :</label>
                                        <input type="text" class="form-control" id="destinatario" name="destinatario" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="apellido">Proceder a :</label>
                                        <select class="form-control" name="proceder" id="proceder">
                                            <option value="Donacion">Donacion</option>
                                            <option value="Destrucción">Destrucción</option>
                                            <option value="Restitución">Restitución</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md3">
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="location.href='index.php';"><i class="fa fa-times"></i> Cancelar</button>
                                <input type="hidden" name="donacion" id="donacion">
                                <!--input type="submit" class="btn btn-primary pull-right" value="Imprimir"-->
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-print"></i> Imprimir</button>
                            </div>
                    </form>
                </div>
            </div>

        </div>
</div>
</section>
</div>

<script type="text/javascript">
    var listaNumeros = <?php echo $listado_elementos; ?>;
    var lista = [];
    $.ajax({
        url: "json_lista_secuestros.php", // Cambiar por la URL de tu archivo PHP
        type: "POST",
        data: {
            listaNumeros: listaNumeros
        }, // Enviar la lista de números al servidor
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                generarTabla(data);
                console.log(data);
                lista = data;
                document.getElementById("donacion").value = JSON.stringify(lista);
            } else {
                alert("No hay datos disponibles");
            }
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });

    function generarTabla(datos) {
        var html = "";
        html += '<table class="table table-striped">';
        html += '<thead>';
        html += '<tr>';
        html += '<th>Auto</th>';
        html += '<th>Caratula</th>';
        html += '<th>Acta Infracción</th>';
        html += '<th>Objeto</th>';
        html += '<th>Descripción</th>';
        html += '<th>Ubicación</th>';
        html += '<th></th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        for (var i = 0; i < datos.length; i++) {
            html += '<tr>';
            html += '<td>' + datos[i].autos + '</td>';
            html += '<td>' + datos[i].caratula + '</td>';
            html += '<td>' + datos[i].acta_infraccion + '</td>';
            html += '<td>' + datos[i].objeto + '</td>';
            html += '<td>' + datos[i].descripcion + '</td>';
            html += '<td>' + datos[i].ubicacion + '</td>';
            html += '<td><button type="button" class="btn btn-danger" onclick="eliminar(' + i + ');">Borrar</button> </td>';
            html += '</tr>';
        }
        html += '<tr><td colspan="7">Fin Listado </td></tr>';
        html += '</tbody>';
        html += '</table>';
        $("#tabla-datos").html(html);
    }

    function eliminar(i) {
        lista.splice(i, 1);
        console.log(lista);
        generarTabla(lista);
        document.getElementById("donacion").value = JSON.stringify(lista);
    }

    function imprimirpdf() {
        window.open("imprimir_donacion.php?id=" + lista, '_blank');
        //window.location.replace("index.php");
        window.location = "index.php";
    }
</script>
<?php
require '../footer.html';
?>