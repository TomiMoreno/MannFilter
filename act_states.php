<?php
include 'conexion.php';

$id = $_POST['id'];
$name = $_POST['name'];
$estado_pedido = $_POST['estado_pedido'];


if (isset($_POST['validacambio'])) {
//se hace el update de los datos modificados por el usuario administrador
$update = "UPDATE estado_pedidos SET name ='$name', estado_pedido='$estado_pedido', status='$status' WHERE Id='$id'";

$consulta = mysqli_query($conexion, $update);
//***************MODIFICADO POR PCR*****************/
?>
<script type="text/javascript">
	window.location="adminestados.php"; 
</script> 
<?php
//**************************************************/


} elseif (isset($_POST['validadelete'])) {
	$delete = "DELETE FROM login WHERE Id='$id'";
	$consultadelete = mysqli_query($conexion, $delete);
} elseif (isset($_POST['novalida'])) {
	?>
	<script type="text/javascript">
		sleep(3000); 
		window.location="adminuser.php"; 
	</script> 
<?php
}

mysqli_close($conexion);

?>