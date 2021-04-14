<?php
include 'conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$username = $_POST['username'];
$password = $_POST['password'];


if (isset($_POST['validacambio'])) {
//se hace el update de los datos modificados por el usuario administrador
$update = "UPDATE login SET nombre = '$nombre', username ='$username', password='$password' WHERE Id='$id'";

$consulta = mysqli_query($conexion, $update);
//***************MODIFICADO POR PCR*****************/
?>
    <script type="text/javascript">
        window.location="adminusergeneral.php"; 
    </script> 
<?php	
//**************************************************/


} elseif (isset($_POST['validadelete'])) {
	$delete = "DELETE FROM login WHERE Id='$id'";
	$consultadelete = mysqli_query($conexion, $delete);
} elseif (isset($_POST['novalida'])) {
	?>
    <script type="text/javascript">
        window.location="adminusergeneral.php"; 
    </script> 
<?php	
}

mysqli_close($conexion);

?>