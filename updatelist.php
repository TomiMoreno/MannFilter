<?php
//* MYSQL POST DE FUNCTIONESTADO.JS *//
include 'conexion.php';
$estado = $_POST['status'];
$documento = $_POST['document_number'];
$material = $_POST['material'];
$fecha = $_POST['date_of_sc']; //la fecha original de la entrega
$nueva_fecha = $_POST['date_of_sc_n']; //la nueva fecha prevista para la entrega
$observaciones = $_POST['observaciones'];
//*   *//

        $sql = "UPDATE pedidos SET estado_pedido='$estado', new_date='$nueva_fecha', observaciones='$observaciones' WHERE document_number = '$documento' AND material='$material' AND date_of_sc='$fecha'";
        $consulta = mysqli_query($conexion, $sql);
        if (!$consulta) {   
            echo 'error al hacer la consulta';
        }

//* VALIDACIONES *//

$sql = "SELECT campo_date, campo_obs FROM estado_pedidos WHERE estado_pedido = $estado";
        $consulta = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_array($consulta);
        if (!$consulta) {   
            echo 'error al hacer la consulta';
        }
        else
        {
           if(($row[0]=="on") && ($row[1]=="on"))
           {
               echo 3;
           }
           if(($row[0]=="on") && ($row[1]=="off"))
           {
               echo 2;
           }
           if(($row[0]=="off") && ($row[1]=="on"))
           {
               echo 1;
           }
           if(($row[0]=="off") && ($row[1]=="off"))
           {
               echo 0;
           }

        }

mysqli_close($conexion);  


?>


