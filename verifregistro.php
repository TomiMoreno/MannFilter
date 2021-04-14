<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   

            function sleep(milliseconds) {
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                break;
                }
                }
            }

        </script>
        <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
        <link rel="stylesheet" type="text/css" href="css/icons.css">
        <link rel="stylesheet" type="text/css" href="css/tablas.css">
        <link rel="shortcut icon" href="img/logo.jpg">

    </head>
    <body>
        <div class="logo">
            <img  class="avatar" src="img/logo.jpg">
            <br>
            <br>

<?php

//*  POST DE REGISTRO.HTML *//
$nombre = $_POST['nombre'];
$username = $_POST['username'];
$pass = $_POST['password'];
$rpass = $_POST['rpassword'];
$supplier = $_POST['supplier'];
$verpedidos = 0;
//* *//

if ($_POST['ComboSelect'] == '0') {
    $verpedidos = 0;
    
} elseif ($_POST['ComboSelect'] == '1') {
    $verpedidos = 1;
    $supplier = 0;
     
} elseif ($_POST['ComboSelect'] == '2') {
    $verpedidos = 2;
    $supplier = 0;
    
} elseif ($_POST['ComboSelect'] == '3') {
    $verpedidos = 3;
    $supplier = 0;
    
}else {
    echo "No hay datos en la variable del combobox";
    die();
}
//* mysql *//
include 'conexion.php';
$query = "INSERT INTO login (nombre, username, password, supplier, ver_pedidos, status) VALUES ('$nombre', '$username', '$pass', $supplier, $verpedidos, 1)";

//* *//
//* VALIDACION *//
if (empty($username)) {
    echo '<h3>el campo de usuario esta sin completar</h3>';
    
    ?>
        <script type="text/javascript">
            sleep(3000); 
            window.location="registro.php"; 
        </script> 
    <?php
            
    
    die();  } elseif (empty($pass)) {
        echo '<h3>el campo de contraseña esta vacio</h3>';
        
        ?>
            <script type="text/javascript">
                sleep(3000); 
                window.location="registro.php"; 
            </script> 
        <?php
        
        die();   
    } else {
        if ($pass === $rpass) {
            
            $consulta = mysqli_query($conexion, $query);
            if (!$consulta) {
                echo '<h3>error al hacer la consulta</h3>';
                echo $username;
                echo " - ";
                echo $pass;
                echo " - ";
                echo $supplier;
                echo " - ";
                echo $verpedidos;

                die(); }
            echo '<h3>el usuario fue creado con exito, será redirigido</h3>';
            ?>
                <script type="text/javascript">
                    sleep(3000); 
                    window.location="adminuser.php"; 
                </script> 
            <?php   
        } else {
            echo '<h3>las contraseñas no coinciden, vuelva a intentarlo</h3>';
            
            ?>
                <script type="text/javascript">
                    sleep(3000); 
                    window.location="registro.php"; 
                </script> 
            <?php
            
            die();
        }
    }

//*  *//

mysqli_close($conexion);  

?>

<footer>
                <h5>Powered by EEST Nº5 JFK</h5>
            </footer>
        </div>
    </body>
</html>