<?php
    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();
    }
?>

<html>
    <head>
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
        <title>Mann-filter</title>
        <meta charset="UTF-8">
        <!--Conexión con JavaScript-->
        <script src="js/cargarpedidos.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
        <link rel="shortcut icon" href="img/logo.jpg">
        <!--Conexión con CSS-->
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
    </head>
    <body>
        <form action="vistapedidos.php">
            <button type="submit" class="pedidos">Volver</button>
        </form>

        <br>

        <h1>Subida de Excel a base de datos</h1>

        <!-- FORMULARIO PARA CARGAR EL ARCHIVO EXCEL -->
        <div id="cargaArchivo">
        </div>
            <form name="formCarga" action="subirXLS.php" method="post" enctype="multipart/form-data" class="subidaArchivo">
                <br>
                <br>
                <input type="file" name="archivo" id="archivo"></input>
                <br>
                <br>
                <br>
                <br>
                <input type="submit" class="cargar" name="solicitud" onclick="saveList()" value="CARGAR PEDIDOS"></input>
                <br>
                <br>
                <br>
                <br>
            </form>


    </body>
</html>