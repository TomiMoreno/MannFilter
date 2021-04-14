<?php
    include 'conexion.php';
    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    $consultavalidar = "SELECT * FROM login WHERE username='$varsesion'";
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();  }

    $consulta = mysqli_query($conexion, $consultavalidar);
    $row = mysqli_fetch_array($consulta);

    
    if ($row['ver_pedidos'] != 0) {
        echo "Estas tratando de ingresar con un usuario que no es proveedor";
        die();
    }

?>
<html>
    <head>
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
        <title>Proovedores</title>
        <meta charset="UTF-8">
        <!--Conexión con JavaScript-->
        <script src="js/function.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
        <script src="js/functionestado.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT E IBA EN EL HEAD -->
        <link rel="shortcut icon" href="img/logo.jpg">
        <!--Conexión con CSS-->
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="stylesheet" href="css/textos.css" type="text/css">
        <link rel="stylesheet" href="css/buttons.css" type="text/css">
    </head>
    <body>
        <a href="adminusergeneral.php"><button type="submit" class="sesion" style="position: absolute; top: 8%;">Administrar usuario</button></a>
        <form action="logout.php">
            <button type="submit" class="sesion">Cerrar sesión</button>
        </form>

        <?php
        echo "<h1>" .$row[1]. " - Lista de productos</h1>";
        ?>
        <form action="updatelist.php" method="POST">
            <!--Creamos un botón con función para que ejecute el JavaScript-->
            <a href="getlist.php"><button class="pedidos" type="button" name="solicitud" onclick="loadList()">VER PEDIDOS</button></a>
        </form>
        <!--Asignamos un ID al texto para que luego, mediante el js, se cambie por lo solicitado-->
        <div id="listArea"><b>Pulse el botón para recargar la lista de pedidos...</b></div>
    </body>
</html>