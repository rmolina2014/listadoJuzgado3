<?php
require_once "../assets/tcpdf/tcpdf.php";
include("listado_secuestros.php");


/*** nuevo ***/

$objeto = new listado_secuestros();

$listado_comisaria_id = (int)$_GET['id'];
/*
$datos = $objeto->obtenerDatosDonacion($listado_comisaria_id);
foreach ($datos as $item) {
    $comisaria = $item['destino'];
    $fecha = $item['fecha'];
}
*/
/**fecha**/
/*
function fechaCastellano($fecha)
{
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia . " de " . $nombreMes . " de " . $anio;
}

$dia = fechaCastellano($fecha);

/** datos****/

?>

<!--DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficio Judicial</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Oficio Judicial</h1>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p>San Juan, 13 de Agosto de 2019.-</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p>SEÑOR DIRECTOR<br>
                    DIRECCIÓN DE DESARROLLO PECUARIO<br>
                    SERV. VETERINARIO DE INSPECCIÓN SANITARIA<br>
                    DE LA PROVINCIA DE SAN JUAN:<br>
                    S------------------/----------------------D:<br>
                </p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p>Tengo el agrado de dirigirme a usted en Autos Nº120242-C c/VEA (BASE DE TRANSFERENCIA S.M 419) CENCOSUD S.A.. Por Inf. a ART. 139 de LEY LP-941-R - Código de Faltas, Fecha 31/07/2019, Acta Nº 102250 y 102588, que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, a fin de solicitarle proceda al transporte para su DONACIÓN de los elementos que se hallan decomisados e intervenidos en el freezer del local comercial sito en AVDA ESPAÑA 1048 NORTE – CAPITAL (BASE DE TRANSFERENCIA SM 419 – VEA CENCOSUD S.A.) a la institución “PARQUE FAUNISTICO–UBICADO EN EL DPTO DE RIVADAVIA”, tales son la cantidad de: 08 MEDIAS RESES DE CARNE VACUNA cuyos precintos de S.V.I.S. son los siguientes: 003320, 003360, 003456, 003458, 003457, 003459, 003460, 003464.- Fdo. Abdo. Enrique G. Mattar- Juez de Faltas- Abda. Adriana Corral de Lobos- Secretaria”.-</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p>Para llevar a cabo esta medida se deberá labrar acta con noticia al Juzgado actuante.-</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p>Sin más le saludo atte.-</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html-->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-6">OFICIO</h1>
                <p class="lead">San Juan, 13 de Agosto de 2019.</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <p><strong>SEÑOR DIRECTOR</strong></p>
                <p>DIRECCIÓN DE DESARROLLO PECUARIO</p>
                <p>SERV. VETERINARIO DE INSPECCIÓN SANITARIA DE LA PROVINCIA DE SAN JUAN:</p>
                <p>Tengo el agrado de dirigirme a usted en Autos Nº120242-C c/VEA (BASE DE TRANSFERENCIA S.M 419) CENCOSUD S.A.. Por Inf. a ART. 139 de LEY LP-941-R - Código de Faltas, Fecha 31/07/2019, Acta Nº 102250 y 102588, que se tramitan por ante este Juzgado de Faltas de Tercera Nominación, a fin de solicitarle proceda al transporte para su DONACIÓN de los elementos que se hallan decomisados e intervenidos en el freezer del local comercial sito en AVDA ESPAÑA 1048 NORTE – CAPITAL (BASE DE TRANSFERENCIA SM 419 – VEA CENCOSUD S.A.) a la institución “PARQUE FAUNÍSTICO–UBICADO EN EL DPTO DE RIVADAVIA”, tales son la cantidad de: 08 MEDIAS RESES DE CARNE VACUNA cuyos precintos de S.V.I.S. son los siguientes: 003320, 003360, 003456, 003458, 003457, 003459, 003460, 003464.- Fdo. Abdo. Enrique G. Mattar- Juez de Faltas- Abda. Adriana Corral de Lobos- Secretaria”.</p>
                <p>Para llevar a cabo esta medida se deberá labrar acta con noticia al Juzgado actuante.</p>
                <p class="text-end signature">Sin más le saludo atte.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>