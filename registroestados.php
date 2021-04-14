<?php
//se verifica que la sesion esté iniciada
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
    if ($row['ver_pedidos'] != 1) {
        echo "Estas tratando de ingresar con un usuario que no es administrador";
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
        <link rel="shortcut icon" href="img/logo.jpg">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="css/general.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
        <link rel="stylesheet" type="text/css" href="css/icons.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">

    </head>
    <body>
        <div class="logo">
            <br>
            <h1>Registro de estado</h1>
            <form action="" method="POST">
                <input type="text" name="NomEstado" id="username" placeholder="Nombre del estado" autocomplete="off" maxlength="15">
                <br>
                <br>
                <br>
                <input type="text" name="EstadoPed" id="estadocod"  placeholder="Codigo del estado">
                <br>
                <br>
                <br>
                Habilitar campo de observaciones<input type="checkbox" name="EstadoOb" id="estadoOb">
                <br> 
                <br> 
                <br>
                Habilitar campo de fechas <input type="checkbox" name="EstadoDate" id="estadodate">
                <button type="submit" name="submit">GENERAR ESTADO</button>
            </form>
            <a href="adminestados.php"><button class="button2">Volver</button></a>
            <footer>
                <h5>Powered by EEST Nº5 JFK</h5>
            </footer>
        </div>
    </body>
</html>


<?php
if (isset($_POST['submit'])) {
    $NomEstado = $_POST['NomEstado'];
    $EstadoPed = $_POST['EstadoPed'];
    $EstadoOb = $_POST['EstadoOb'];
    $EstadoDate = $_POST['EstadoDate'];

    if($EstadoDate==''){
        $EstadoDate="off";
    }

    if($EstadoOb==''){
        $EstadoOb="off";
    }

    $sql = "INSERT INTO `estado_pedidos` (`Id`, `name`, `estado_pedido`, `status`, `campo_obs`, `campo_date`) VALUES ('', '$NomEstado', '$EstadoPed', '0', '$EstadoOb', '$EstadoDate')";
    $insert = mysqli_query($conexion, $sql);

    if (!$insert) {
    echo "No se puedo hacer el estado";
    die();
    }
    ?>
    <script type="text/javascript">
        window.location="adminestados.php"; 
    </script> 
<?php	
}
?>