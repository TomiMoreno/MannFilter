<?php
//* MYSQL POST DE FUNCTIONESTADO.JS *//
include 'conexion.php';
$documento = $_POST['document_number'];
$material = $_POST['material'];
$fecha = $_POST['date_of_sc'];
//*   *//


//* VALIDACIONES *//


        $sql = "UPDATE pedidos SET en_stock=1 WHERE document_number = '$documento' AND material='$material' AND date_of_sc='$fecha'";
        $consulta = mysqli_query($conexion, $sql);
        
        if (!$consulta) {   
            echo 'error al hacer la consulta';
        }
   


        mysqli_close($conexion);  

?>


