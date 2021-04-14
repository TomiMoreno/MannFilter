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

 <a href="adminuser.php"><button class="pedidos">Volver a la pagina anterior</button></a>
<?php 

$sql = "SELECT * FROM lista_negra";

$query = mysqli_query($conexion, $sql);

echo "<br><br><br><br><br>";

echo"<table id='listado'>
    <tr>
    <th> Usuario </th>
    <th> Desbloquear </th>
    </tr>";

while ($row = mysqli_fetch_array($query)) {
    echo "<tr>";
    echo "<td class='item'>" .$row['usuario']. "</td>";
?>
	<td class="item"><a href="unlock.php?id=<?php echo $row['usuario'];?>">Desbloquear</a></td>
	</tr>
<?php
}
?>
	
</body>
</html>