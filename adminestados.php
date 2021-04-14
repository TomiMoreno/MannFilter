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
     <meta charset="utf-8">
     <link rel="shortcut icon" href="img/logo.jpg">
 	<title>Administrador de Estados</title>
     <link rel="stylesheet" type="text/css" href="css/style.css">
     <link rel="stylesheet" type="text/css" href="css/buttons.css">
     <link rel="stylesheet" type="text/css" href="css/textos.css">
     <link rel="stylesheet" type="text/css" href="css/tablas.css">
    <script src="js/confirmacion.js" type="text/javascript"></script>
 </head>
 <body>
    <h2>ADMINISTRADOR DE ESTADOS</h2>
        <a href="vistapedidos.php"><button type="submit" class="button1">Volver a la pagina principal</button></a>
        <a href="registroestados.php"><button type="submit" class="regis">Registrar nuevo estado</button></a>
 		<?php
 		include 'conexion.php';
 		$sql = "SELECT * FROM estado_pedidos WHERE status = 0"; //TRAEMOS SÓLO LOS HABILITADOS, MARCADOS CON STATUS 0
 		$result = mysqli_query($conexion, $sql);
 		echo "<br><br><br><br>";
            echo"<table id='listado'>
                <tr>
                <th> Nombre </th>
                <th> Estado pedido </th>
                <th> . </th>
                </tr>";

            while ($row = mysqli_fetch_array($result)) {
            	echo "<tr>";
            	echo "<td class='item'>" .$row['name']. "</td>";
            	echo "<td class='item'>" .$row['estado_pedido']. "</td>";
            ?> 
            <td> 
            <a href="updatestates.php?id=<?php echo $row['Id'];?>" class="link_item">Editar</a>
            <a href="deletestates.php?id=<?php echo $row['Id'];?>" class="link_item_delete">Eliminar</a>
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