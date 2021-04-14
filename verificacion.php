<?php
    session_start(); //esto va una sola vez y al comienzo
?>

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
 

//incluimos la conexion a la base de datos
include 'conexion.php';
//aca se valida que el usuario haya dado click a el submit
if(isset($_POST['submit'])){
    $usuario = $_POST['username'];
    $pass = $_POST['password'];
    //validacion de campos vacios
    if (empty($usuario)){
        echo '<h3>Usuario en blanco</h3>
        <h5>Coloque su usuario por favor.</h5>';
        
        ?>
            <script type="text/javascript"> 
                sleep(3000);
                window.location="index.html"; 
            </script> 
        <?php

        die ();  }
        if(empty($pass)){
            echo '<h3>Contraseña en blanco</h3>
            <h5>Coloque su contraseña por favor.</h5>';
            
            ?>
                <script type="text/javascript"> 
                    sleep(3000);
                    window.location="index.html"; 
                </script> 
            <?php
            
            die (); } 

            //verificamos primero que el usuario no esté bloqueado
            $sql = "SELECT * FROM lista_negra WHERE usuario='$usuario'";
            $respuesta = mysqli_query($conexion, $sql);
            $coincidencias = mysqli_num_rows($respuesta);
            if($coincidencias>0){
                $_SESSION['denegado'] = $usuario;
                
                ?>
                    <script type="text/javascript"> 
                        window.location="bloqueado.php"; 
                    </script> 
                <?php
                
                die();
                
            }

            //consultas sql
            $sql = "SELECT * FROM login WHERE username='$usuario' AND password='$pass'";
            $respuesta = mysqli_query($conexion, $sql);
            $rows = mysqli_num_rows($respuesta);
            $userow = mysqli_fetch_array($respuesta);
            //validacion que la consulta no de error
            if(!$respuesta){
            echo 'error al hacer la consulta';
            ?>
                <script type="text/javascript"> 
                    window.location="verificacion.php"; 
                </script> 
            <?php
            die(); }


            //con este rows se pregunta si la variable en la que se guardaron los datos de sesion
            //tienen algo
            if($rows > 0){
                switch ($userow['ver_pedidos']) {
                    case 0:
                        echo '<h3>Conexión exitosa.</h3>
                            <h5>Está siendo redirigido... Espere, por favor.</h5>';
                       // session_start();
                        $_SESSION['login_ok'] = true;
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['supplier'] = $userow['supplier'];
                        ?>
                            <script type="text/javascript"> 
                                window.location="pedidos.php"; 
                            </script> 
                        <?php 
                    break;

                    case 1:
                        echo '<h3>Conexion exitosa</h3>
                            <h5>Esta siendo redirigido... Espere, por favor</h5>';
                        //session_start();
                        $_SESSION['login_ok'] = true;
                        $_SESSION['usuario'] = $usuario;
                        ?>
                            <script type="text/javascript"> 
                                window.location="vistapedidos.php"; 
                            </script> 
                        <?php
                        //header ('Refresh: 3; URL=vistapedidos.php'); 
                    break;

                    case 2:
                        echo '<h3>Conexion exitosa</h3>
                            <h5>Esta siendo redirigido... Espere, por favor</h5>';
                        //session_start();
                        $_SESSION['login_ok'] = true;
                        $_SESSION['usuario'] = $usuario;
                        ?>
                            <script type="text/javascript"> 
                                window.location="vistapedidos2.php"; 
                            </script> 
                        <?php
                    break;             

                    case 3:
                        echo '<h3>Conexion exitosa</h3>
                            <h5>Esta siendo redirigido... Espere, por favor</h5>';
                        //session_start();
                        $_SESSION['login_ok'] = true;
                        $_SESSION['usuario'] = $usuario;
                        ?>
                            <script type="text/javascript"> 
                                window.location="vistapedidos3.php"; 
                            </script> 
                        <?php
                    break;             }
            }  else {
                echo '<h3>Datos incorrectos</h3>
                <h5>Coloque sus datos correctamente por favor.</h5>';

                //******************BLOQUEO DE IP AL INTENTAR ACCEDER DOS VECES SIN EXITO******************/

                    $ipaddress = $_SERVER['REMOTE_ADDR'];
                    
                    if(!isset($_SESSION['denied'])){
                        $_SESSION['denied'] = $ipaddress;

                    }
                    else{
                            echo "else";
                            $_SESSION['denegado'] = $usuario; //obtenemos el usuario que intentó ingresar
                            ?>
                                <script type="text/javascript"> 
                                    window.location="bloqueado.php"; 
                                </script> 
                            <?php       
                            die();

                    }
                

                //*****************************************************************************************/

                ?>
                   <script type="text/javascript"> 
                        window.location="index.html"; 
                    </script> 
                <?php
                die (); }

                        }   
            mysqli_close($conexion);  
?>
            <footer>
                <h5>Powered by EEST Nº5 JFK</h5>
            </footer>
        </div>
    </body>
</html>
