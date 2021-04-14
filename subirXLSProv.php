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
        <script src="js/cargarproveedores.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
        <link rel="shortcut icon" href="logo.jpeg">
        <!--Conexión con CSS-->
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">
    </head>
    <body>

    <form action="subidaexcelprov.php">
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
         $archivo = "xls/".$file_name;
         $inputFileType = PHPExcel_IOFactory::identify($archivo);
         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
         $objPHPExcel = $objReader->load($archivo);
         $sheet = $objPHPExcel->getSheet(0); 
         $highestRow = $sheet->getHighestRow(); 
         $highestColumn = $sheet->getHighestColumn();

         $num=0;
         for ($row = 2; $row <= $highestRow; $row++){ 
            $num++;
            $supplier = $sheet->getCell("A".$row)->getValue();
            $name = $sheet->getCell("B".$row)->getValue();


            //GENERA CONTRASEÑA ALEATORIA
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pass=substr(str_shuffle($permitted_chars), 0, 8);
            

            
            //CONSULTA PARA DAR DE ALTA LOS PROVEEDORES DEL EXCEL
            $sql = "INSERT INTO login(nombre, username, password, supplier, ver_pedidos, status) VALUES ('$name','','$pass',$supplier,0,1)";

            $consulta = mysqli_query($conexion, $sql);


         }

            
            echo "<h1>CARGA DE PROVEEDORES FINALIZADA</h1>";
            echo "<br><br><h1>Se cargaron ".$num." proveedores nuevos</h1>";


       //Cierra la conexión
       mysqli_close($conexion);
     

      }
      else{
         ?>
            <br>

            <h1>Subida de Excel a base de datos</h1>
         <form name="formCarga" action="subirXLSProv.php" method="post" enctype="multipart/form-data" class="subidaArchivo">
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