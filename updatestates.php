<?php
 //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
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
 	<title>Administrador de Estados</title>
 	<link rel="stylesheet" type="text/css" href="css/style.css">
 </head>
 <body>
 		<?php
 		include 'conexion.php';
        //aca se consulta segun el usuario que fue clickeado
        $id = $_GET['id'];
 		$sql = "SELECT * FROM estado_pedidos WHERE Id = '$id'";
 		$result = mysqli_query($conexion, $sql);
        echo "<form action='act_states.php' method='post'";
 		echo "<br><br><br><br>";
            echo"<table id='listado'>
                <tr>
                <th> Nombre_Estado </th>
                <th> Estado_pedido </th>
                <th> VALIDAR </th>
                </tr>";

            while ($row = mysqli_fetch_array($result)) {
            	echo "<tr>";
                // Este valor se hace invisible para en act_users.php pueda usarse a modo de filtracion
                echo "<input type='hidden' class='' value='".$row['Id'] ."' name='id'>";
                echo "<td> <input type='text' class='' value='".$row['name'] ."' name='name'> </td>";
                echo "<td> <input type='number' min='0' class='' value='".$row['estado_pedido'] ."' name='estado_pedido'> </td>";
                echo "<td>  <input type='submit' name='validacambio' value='VALIDAR'></td>";
            	echo "</tr>";   
            }
        echo "</form>";
        mysqli_close($conexion);
 		?>
    </body>
    </html>