<?php
include 'conexion.php';

$id = $_GET['id'];

    //CAMBIAMOS EL STATUS A 0 PARA INDICAR QUE ESTÁ DADO DE BAJA
    $delete = "UPDATE login SET status = 0 WHERE Id='$id'";
    $consultadelete = mysqli_query($conexion, $delete);
    ?>
    <script type="text/javascript">
        window.location="adminuser.php"; 
    </script> 
<?php	
    
    mysqli_close($conexion);
?>