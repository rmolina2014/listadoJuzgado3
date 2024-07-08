<?php
require '../cabecera.php';
require '../menu.php';
include("../listado_secuestros/listado_secuestros.php");
?>
<!--link href="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.css" rel="stylesheet"-->
<link rel="stylesheet" href="../js/DataTables/datatables.min.css" />

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
        <div class="margin">
            <h4 class="text-center">Registro de Secuestros</h4>
            <br>
            <!--p> <a class="btn btn-primary" href="nuevo.php">Adicionar Nueva Nota </a> </p-->
            <!--button type="button" class="btn btn-primary" onclick="sendToPHP()">Seleccionar</button-->
            <table id="listado" class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>AUTOS</th>
                        <th>FECHA</th>
                        <th>ACTA</th>
                        <th>CARATULA</th>
                        <th>REPARTICION</th>
                        <th>OBJETO</th>
                        <th>DESTINO</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        $objeto = new listado_secuestros();
                        $listados = $objeto->registro_secuestro_historico();
                        if ($listados > 0) {
                            foreach ($listados as $item) {
                        ?>
                                <tr>
                                    <input type="hidden" id="<?php echo $item['id']; ?>">
                                    <td><?php echo $item['autos']; ?></td>
                                    <td><?php echo $item['fecha']; ?></td>
                                    <td><?php echo $item['acta']; ?></td>
                                    <td><?php echo $item['caratula']; ?></td>
                                    <td><?php echo $item['reparticion']; ?></td>
                                    <td><?php echo $item['objeto']; ?></td>
                                    <td><?php echo $item['destino']; ?></td>
                                    <td></td>
                                </tr>
                        <?php
                            }
                        } else 'Sin datos para mostar.';

                        ?>
                    </tbody>
            </table>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require '../footer.html';
?>