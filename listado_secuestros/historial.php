<?php
require '../cabecera.php';
require '../menu.php';
include("../listado_secuestros/listado_secuestros.php");
?>
<!--link href="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.css" rel="stylesheet"-->
<link rel="stylesheet" href="../js/DataTables/datatables.min.css" />
<style>
    @media print {
        #no {
            display: none;
        }

        footer {
            display: none;
        }
    }
</style>

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
        <!--button id="print-button">Imprimi1r</button-->
        <a href="javascript:window.print();" id="no" class="btn btn-primary">Imprimir</a>
        <div id="printable-div">
            <div class="margin">
                <h4 class="text-center">Registro de Secuestros</h4>
                <br>
                <!--p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nueva Nota </a> </p-->
                <!--button type="button" class="btn btn-primary" onclick="sendToPHP()">Seleccionar</button-->
                <table id="listado" class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>AUTOS</th>
                            <th>ACTA</th>
                            <th>CARATULA</th>
                            <th>REPARTICION</th>
                            <th>OBJETO</th>
                            <th>DESTINO</th>
                            <th> </th>
                        </tr>
                        <thead>
                        <tbody>
                            <?php
                            $objeto = new listado_secuestros();
                            $listados = $objeto->listado_registro_secuestro_detalle_objeto();
                            if ($listados > 0) {
                                foreach ($listados as $item) {
                            ?>
                                    <tr>
                                        <input type="hidden" id="<?php echo $item['id']; ?>">
                                        <td><?php

                                            echo $formattedDate = date('d-m-Y', strtotime($item['fecha_registro']));

                                            ?></td>
                                        <td><?php echo $item['autos_registro']; ?></td>

                                        <td><?php echo $item['acta_infraccion']; ?></td>
                                        <td><?php echo $item['caratula_registro']; ?></td>
                                        <td><?php echo $item['reparticion_registro']; ?></td>
                                        <td><?php echo $item['objeto']; ?></td>
                                        <td><?php echo $item['destino']; ?></td>
                                        <td>
                                            <?php
                                            if ($item['destino'] == 'Donacion') {
                                                echo $item['donado_a'];
                                            }
                                            if ($item['destino'] == 'Restitucion') {
                                                echo $item['restituido_a'];
                                            }

                                            ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else 'Sin datos para mostar.';
                            ?>
                        </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<script>
    const printButton = document.getElementById('print-button');
    const printableDiv = document.getElementById('printable-div');

    printButton.addEventListener('click', () => {
        const newWindow = window.open('', '_blank', 'width=600,height=400');
        newWindow.document.body.innerHTML = printableDiv.outerHTML;
        newWindow.print();
        newWindow.close(); // Optionally close the new window after printing
    });
</script>

<!-- /.content-wrapper -->
<?php
require '../footer.html';
?>