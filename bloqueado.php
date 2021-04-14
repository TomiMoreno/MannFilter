<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
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
                
                //Recuperamos usuario e IP de ingreso bloqueado
                $usuario = $_SESSION['denegado'];

                if(isset($_SESSION['denied'])){
                    $IP = $_SESSION['denied'];

                    //Grabamos en la lista negra el usuario y la IP asignada
                    include 'conexion.php';
                    $query = "INSERT INTO `lista_negra` (`usuario`, `IP`) VALUES ('$usuario', '$IP')";

                    $consulta = mysqli_query($conexion, $query);

                    mysqli_close($conexion);  
                }

               

                //Mensaje al usuario
                echo '<h3>El usuario '.$usuario.' ha sido bloqueado</h3>';
                echo '<h3>Por favor comuníquese con el administrador de Mann Filters</h3>';
                

                  
?>
            <footer>
                <h5>Powered by EEST Nº5 JFK</h5>
            </footer>
        </div>
    </body>
</html>
