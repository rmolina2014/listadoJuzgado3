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
        <h5>Listado de Secuestros</h5>
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
                        <?php echo $item['autos'] . '-' . $item['caratula'] . '-' . $item['objeto']; ?>
                    </li>
            <?php
                }
            }
            ?>
        </ul>

        <h5>Acciones</h5>
        <div class="d-grid gap-2 d-md-block">
            <form action="imprimir_donacion.php" method="POST">
                <input type="hidden" name="donacion" id="donacion" >
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

            <!--script>
                document.getElementById("donacion").value = <?php echo $_POST['caja_valor']; ?>;
                document.getElementById("restitucion").value = <?php echo json_encode($list); ?>;
                document.getElementById("destruccion").value = <?php echo json_encode($list); ?>;
            </script-->
        </div>

        <script>
            document.getElementById("donacion").value = JSON.stringify(<?php echo $_POST['caja_valor']; ?>);
            document.getElementById("restitucion").value = JSON.stringify(<?php echo $_POST['caja_valor']; ?>);
            document.getElementById("destruccion").value = JSON.stringify(<?php echo $_POST['caja_valor'];; ?>);
            console.log(list)
        </script>



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require '../footer.php';
?>