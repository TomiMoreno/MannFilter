<?php

    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();
    }
?>

<html>
    <head>
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
        <title>Mann-filter</title>
        <meta charset="UTF-8">
        <script src="js/cargarpedidos.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
        <link rel="shortcut icon" href="logo.jpeg">
        <!--Conexión con CSS-->
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
    </head>
    <body>

    <form action="subidaexcel.php">
            <button type="submit" class="pedidos">Volver</button>
        </form>

<?php

   if(isset($_FILES['archivo'])){
      $errors= "";

      $file_name = $_FILES['archivo']['name'];
      $file_size = $_FILES['archivo']['size'];
      $file_tmp = $_FILES['archivo']['tmp_name'];
      
      $file_type = $_FILES['archivo']['type'];
      $tmp = explode('.',$_FILES['archivo']['name']);
      
      $file_ext=strtolower(end($tmp));
     
      $expensions= array("xls","xlsx");
     
      if(in_array($file_ext,$expensions)=== false){
         $errors="El archivo debe ser XLS o XLSX.";
      }
     
      if($file_size > 2097152) {
         $errors='El archivo pesa más de 2MB';
      }
     
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"xls/".$file_name);

         //Conexión con la base de datos
         include 'conexion.php';

         require_once 'Classes/PHPExcel.php';
         
         $objPHPExcel = new PHPExcel();
         $archivo = "xls/".$file_name;
         $inputFileType = PHPExcel_IOFactory::identify($archivo);
      
         

         //$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory;
         //PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

        $cm = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        \PHPExcel_Settings::setCacheStorageMethod($cm);

         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
         $objReader->setReadDataOnly(true);
         $objPHPExcel = $objReader->load($archivo);
         $sheet = $objPHPExcel->getSheet(0); 
         $highestRow = $sheet->getHighestDataRow(); 
         //$highestColumn = $sheet->getHighestDataColumn();

         //PONEMOS TODOS LOS REGISTRO CON EL CAMPO en_stock a 1
         $sql = "UPDATE pedidos SET en_stock = 2 WHERE en_stock = 1";
         $consulta = mysqli_query($conexion, $sql);
         $sql = "UPDATE pedidos SET en_stock = 1 WHERE en_stock = 0";
         $consulta = mysqli_query($conexion, $sql);

         $fecha_alta = explode("_", $file_name);
         
         $sql = "SET AUTOCOMMIT=0";
         $consulta = mysqli_query($conexion, $sql);
         
         $sql = "START TRANSACTION";
         $consulta = mysqli_query($conexion, $sql);
            $row = 2;
         while ($sheet->getCell("A".$row)->getValue()!=""){ 
            $supplier = $sheet->getCell("A".$row)->getValue();
            $name = $sheet->getCell("B".$row)->getValue();
            $document = $sheet->getCell("C".$row)->getValue();
            $item = $sheet->getCell("D".$row)->getValue();
            $material = $sheet->getCell("E".$row)->getValue();
            $description = $sheet->getCell("F".$row)->getValue();

            /* CAMBIO DE ORDEN EN EL DOCUMENTO EXCEL
               G=FECHA ESPERADA
               H=CANTIDAD PEDIDA
               I=UNIDAD
            ****************************************/

            $ordered_quantit = $sheet->getCell("H".$row)->getValue();
            $un = $sheet->getCell("I".$row)->getValue();
            /********* PROCEDIMIENTO PARA SOLUCIONAR EL PROBLEMA DE FECHAS **********/
            $fecha_raw = $sheet->getCell("G".$row)->getValue();
            list($dia, $mes, $año) = explode('.', $fecha_raw);
            $date_of_sc = $año."".$mes."".$dia;
            $diasfijo = $sheet->getCell("J".$row)->getValue();
            $new_date = $date_of_sc;
            /************************************************************************/

            //VERIFICAMOS SI EXISTE EL PEDIDO.
            //EN CASO QUE EXISTA, ACTUALIZAMOS EL CAMPO en_stock a 0
            
            $sql = "SELECT COUNT(1) AS cantidad FROM pedidos WHERE supplier = ".$supplier." AND document_number = '".$document."' AND material = '".$material."' AND date_of_sc='".$date_of_sc."' AND `ordered quantit` = ".$ordered_quantit."";
            $consulta = mysqli_query($conexion, $sql);
            $cantrow = mysqli_fetch_array($consulta);

            if($cantrow['cantidad']==1){
               //$sql = "UPDATE pedidos SET en_stock = 0, devolucion = 'D', dias_fijo = $diasfijo, estado_pedido=5  WHERE supplier = ".$supplier." AND document_number = '".$document."' AND material = '".$material."' AND date_of_sc='".$date_of_sc."' AND `ordered quantit` = ".$ordered_quantit." AND en_stock = 2";
               $sql="CALL SP_DEVOLUCION(".$diasfijo.", ".$supplier.",'".$document."','".$material."','".$date_of_sc."',".$ordered_quantit.")";
               $consulta = mysqli_query($conexion, $sql);

               //$sql = "UPDATE pedidos SET en_stock = 0, devolucion = '', dias_fijo = $diasfijo  WHERE supplier = ".$supplier." AND document_number = '".$document."' AND material = '".$material."' AND date_of_sc='".$date_of_sc."' AND `ordered quantit` = ".$ordered_quantit." AND en_stock = 1";
               $sql="CALL SPNODEVOLUCION(".$diasfijo.", ".$supplier.",'".$document."','".$material."','".$date_of_sc."',".$ordered_quantit.")";
               $consulta = mysqli_query($conexion, $sql);

            }
            else{

               
               //EN CASO QUE NO EXISTA EL PEDIDO, LO DAMOS DE ALTA
               $sql="CALL SP_CARGARPEDIDO(".$supplier.",'".$name."','".$document."',".$item.",'".$material."','".$description."',".$ordered_quantit.",'".$un."','".$date_of_sc."','".$new_date."',".$diasfijo.",'".$fecha_alta[0]."')";
               $consulta = mysqli_query($conexion, $sql);
            

            }   

            
            $row = $row + 1;

         }

         
         $sql = "COMMIT";
         $consulta = mysqli_query($conexion, $sql);

         $sql = "SET AUTOCOMMIT=1";
         $consulta = mysqli_query($conexion, $sql);

            $objPHPExcel->disconnectWorksheets();
            $objPHPExcel->garbageCollect(); // Add this too
            unset($objReader, $objPHPExcel);

            
            echo "<h1>CARGA DE PEDIDOS FINALIZADA</h1>";
            echo "<br><br><h1>Se cargaron ".$row." pedidos nuevos</h1>";


       //Cierra la conexión
       mysqli_close($conexion);
     

      }
      else{
         ?>
            <br>

            <h1>Subida de Excel a base de datos</h1>

         <form name="formCarga" action="subirXLS.php" method="post" enctype="multipart/form-data" class="subidaArchivo">
            <br>
            <br>
            <br>
            <br>
            <br>
            <?php
               echo $errors;
            ?>
            <br>
            <br>
            <br>
            <br>
            <br>
         </form>

         <?php
      }
   }

   
?>
      </body>
</html>