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
    if ($row['ver_pedidos'] != 1) {
        echo "Estas tratando de ingresar con un usuario que no es administrador";
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="js/registro.js" type="text/javascript"></script>
        
        
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
            <h1>Registro</h1>
            <form method="post" action="verifregistro.php">
            <div class="icono1">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario..." autocomplete="off" maxlength="16">
            </div>
            <br>
            <div class="icono1">
            <input type="text" name="username" id="username" placeholder="Login de usuario..." autocomplete="off" maxlength="15">
            </div>
            <br>
            <div class="icono2">
            <input type="password" name="password" id="password" placeholder="Contraseña..." maxlength="15">
            <img src="img/mostrar.png" alt="Mostrar contraseña" id="boton" onclick="mostrarContrasena()">
            </div>
            <script>
                var boton = document.getElementById('boton');
                var input = document.getElementById('password');
                function mostrarContrasena(){
                    if(input.type == "password"){
                        input.type = "text";
                        boton.src = "img/ocultar.png";
                        /*setTimeout("ocultar()", 2000);*/
                    }  
                    else{ 
                        input.type = "password";
                        boton.src = "img/mostrar.png";
                    }
                }
                function ocultar (){
                    input.type = "password";
                    boton.src = "img/ocultar.png"
                }
            </script>
            <br>
            <div class="icono2">
            <input type="password" name="rpassword" id="rpassword" placeholder="Repita contraseña..." maxlength="15">
            </div>
            <br>
            <select id="tipous" name="ComboSelect" onchange="ShowSelected()">
                <option value="1">Usuario Administrador</option>
                <option value="2">Usuario Solo de lectura</option>
                <option value="3">Usuario Gestor</option>
                <option value="0">Usuario Proveedor</option>
            </select>
            <div class="icono2" id="elementoOcult" style="display: none;">
            <input type="text" name="supplier" id="supplier" placeholder="Supplier... " autocomplete="off" maxlength="15">
            </div>
            <br> <br>
            <button type="submit" name="submit">REGISTRARSE</button>
            </form>
            <a href="adminuser.php"><button class="button2" >Volver</button></a>
            <footer>
                <h5>Powered by EEST Nº5 JFK</h5>
            </footer>
        </div>
    </body>
</html>