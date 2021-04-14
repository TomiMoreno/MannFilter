<?php
    include 'conexion.php';
    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    $consultavalidar = "SELECT * FROM login WHERE username='$varsesion'";
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();
    }
    $consulta = mysqli_query($conexion, $consultavalidar);
    $row = mysqli_fetch_array($consulta);
    if ($row['ver_pedidos'] != 2) {
        echo "Estas tratando de ingresar con un usuario que no es lectura";
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
        <script src="js/verpedidos.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
        <script src="js/functionestado.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT E IBA EN EL HEAD -->

        <link rel="shortcut icon" href="img/logo.jpg">
        <!--Conexión con CSS-->
        <link rel="stylesheet" type="text/css" href="css/tablas.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
    </head>
    <body>
        <form action="logout.php">
            <button type="submit" class="sesion">Cerrar sesión</button>
        </form>

        <a href="adminusergeneral.php"><button type="submit" class="sesion" style="position: absolute; top: 8%;">administrar usuario</button> </a>

        <br>
        <h1>Usuario: <?php echo $row['nombre'] ?> - Lista de productos</h1>
        <form>
        <!--Creamos un botón con función para que ejecute el JavaScript-->
        <button class="pedidos" type="button" name="solicitud" onclick="loadList()">VER PEDIDOS</button> 
        <!--Filtros de proveedores y materiales, filtran por medio de AJAX-->
        <input type="text" id="filtroSupp" placeholder="CÓD. PROV. (VENDOR)" oninput="loadList()" onkeypress="capturaEnter(event)" autocomplete="off">
        <input type="text" id="filtroProv" placeholder="FILTRAR PROVEEDORES" oninput="loadList()" onkeypress="capturaEnter(event)" autocomplete="off">
        <input type="text" id="filtroMat" placeholder="FILTRAR MATERIALES" oninput="loadList()" onkeypress="capturaEnter(event)" autocomplete="off">
        </form>



        <br><br>
        
        <!--Asignamos un ID al texto para que luego, mediante el js, se cambie por lo solicitado-->
        <div id="listArea"></div>
    </body>
</html>