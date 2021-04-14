<?php
 //se verifica que la sesion esté iniciada
    include 'conexion.php';
    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    $consultavalidar = "SELECT * FROM login WHERE username='$varsesion'";
    $consulta = mysqli_query($conexion, $consultavalidar);
    $row = mysqli_fetch_array($consulta);
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
     <meta charset="utf-8">
     <link rel="shortcut icon" href="img/logo.jpg">
 	<title>administrador de usuarios</title>
     <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" type="text/css" href="css/buttons.css">
     <link rel="stylesheet" type="text/css" href="css/textos.css">
     <link rel="stylesheet" type="text/css" href="css/tablas.css">
    <script src="js/confirmacion.js" type="text/javascript"></script>
 </head>
 <body>
    <h2>CAMBIAR USUARIO/CONTRASEÑA</h2>
        <a href="vistapedidos.php"><button type="submit" class="button1">Volver a la pagina principal</button></a>

 		<?php  
 		$sql = "SELECT * FROM login WHERE username = '$varsesion'"; //TRAEMOS SÓLO LOS USUARIOS LOGEADOS EN ESTA SESION
 		$result = mysqli_query($conexion, $sql);
 		echo "<br><br><br><br><br>";
            echo"<table id='listado'>
                <tr>
                <th> Nombre </th>
                <th> Usuario </th>
                <th> Contraseña </th>
                <th> . </th>
                </tr>";

            while ($row = mysqli_fetch_array($result)) {
            	echo "<tr>";
                echo "<td class='item'>" .$row['nombre']. "</td>";
                echo "<td class='item'>" .$row['username']. "</td>";
            	echo "<td class='item'>" .$row['password']. "</td>";
            ?> 
            <td> 
            <a href="update.php?id=<?php echo $row['Id'];?>" class="link_item">Editar</a>
            </td>
            <?php
            	echo "</tr>";
                
            }

        // se creo una tabla con un array para que recorra la tabla de los usuarios, como en los anteriores
        // la variable id es creada en el href línea 38, para que en el siguiente documento se use a modo de filtracion
          mysqli_close($conexion);
 		?>
 </body>
 </html>