<?php
 //se verifica que la sesion esté iniciada
    include 'conexion.php';
    session_start();
    $varsesion = $_SESSION['usuario'];
    $consultavalidar = "SELECT * FROM login WHERE username='$varsesion'";
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();
    }
    $consulta = mysqli_query($conexion, $consultavalidar);
    $row = mysqli_fetch_array($consulta);
    if ($row['ver_pedidos'] == 1) {
        //CODIGO SOLO PARA ADMINISTRADORES
        ?>
        <!DOCTYPE html>
 <html>
 <head>
 <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
    <meta charset="utf-8">
    <title>administrador de usuarios</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" type="text/css" href="css/buttons.css">
 </head>
 <body>
        <form action="adminuser.php">
            <button type="submit" class="pedidos">Volver</button>
        </form>
        <?php
        include 'conexion.php';
        //aca se consulta segun el usuario que fue clickeado
        $id = $_GET['id'];
        $sql = "SELECT * FROM login WHERE Id = '$id'";
        $result = mysqli_query($conexion, $sql);
        echo "<form action='act_users.php' method='post'";
        echo "<br><br><br><br>";
            echo"<table id='listado'>
                <tr>
                <th> Nombre </th>
                <th> Usuario </th>
                <th> Contraseña </th>
                <th> Supplier </th>
                <th> Tipo de usuario </th>
                <th> VALIDAR </th>
                </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                // Este valor se hace invisible para en act_users.php pueda usarse a modo de filtracion
                echo "<input type='hidden' class='' value='".$row['Id'] ."' name='id'>";
                echo "<td> <input type='text' class='' value='".$row['nombre'] ."' name='nombre'> </td>";
                echo "<td> <input type='text' class='' value='".$row['username'] ."' name='username'> </td>";
                echo "<td> <input type='text' class='' value='".$row['password'] ."' name='password'> </td>";
                echo "<td> <input type='text' class='' value='".$row['supplier'] ."' name='supplier'> </td>";
                echo "<td> <input type='number' max='3' min='0' class='' value='".$row['ver_pedidos'] ."' name='ver_pedidos'> </td>";
                echo "<td>  <input type='submit' name='validacambio' value='VALIDAR'></td>";
                echo "</tr>";   
            }
        echo "</form>";
        mysqli_close($conexion);
        ?>
    </body>
    </html>
       <?php 
    } else{ ?>
        <!DOCTYPE html>
 <html>
 <head>
 <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
    <meta charset="utf-8">
    <title>administrador de usuarios</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" type="text/css" href="css/buttons.css">
 </head>
 <body>
        <form action="adminusergeneral.php">
            <button type="submit" class="pedidos">Volver</button>
        </form>
        <?php
        include 'conexion.php';
        //aca se consulta segun el usuario que fue clickeado
        $id = $_GET['id'];
        $sql = "SELECT * FROM login WHERE Id = '$id'";
        $result = mysqli_query($conexion, $sql);
        echo "<form action='act_users2.php' method='post'";
        echo "<br><br><br><br>";
            echo"<table id='listado'>
                <tr>
                <th> Nombre </th>
                <th> Usuario </th>
                <th> Contraseña </th>
                <th> VALIDAR </th>
                </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                // Este valor se hace invisible para en act_users.php pueda usarse a modo de filtracion
                echo "<input type='hidden' class='' value='".$row['Id'] ."' name='id'>";
                echo "<td> <input type='text' class='' value='".$row['nombre'] ."' name='nombre' readonly='readonly'> </td>";
                echo "<td> <input type='text' class='' value='".$row['username'] ."' name='username'> </td>";
                echo "<td> <input type='text' class='' value='".$row['password'] ."' name='password'> </td>";
                echo "<td>  <input type='submit' name='validacambio' value='VALIDAR'></td>";
                echo "</tr>";   
            }
        echo "</form>";
        mysqli_close($conexion);
        ?>
    </body>
    </html>
    <?php
    }
 ?>
 