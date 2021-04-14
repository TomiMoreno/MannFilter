<?php
    
    //se verifica que la sesion esté iniciada
    session_start();
    $varsesion = $_SESSION['usuario'];
    if($varsesion == null || $varsesion = ''){
        echo 'Usted no puede acceder a esta pagina';
        die();
    }
            //Conexión con la base de datos
            include 'conexion.php';
            //Declaro la variable mediante POST
            $supp = $_POST['supp'];
            $nombre = $_POST['name'];
            $descripcion = $_POST['description'];


            //Consulta y filtra por columna "document_number", además filtra también por proveedor y material
            //CONSULTA INTERMINABLE DONDE TRAE LOS ESTADOS DE LOS PEDIDOS DESTE LA TABLA
            //ESTADO_PEDIDOS. DE ESTA MANERA LOS ESTADOS YA NO QUEDAN HARDCODEADOS
            //CORRECIÓN DE LA QUERY DE PEDIDOS
            if($supp=="0")
            {
                $sql = "SELECT pedidos.supplier, pedidos.name as proveedor, pedidos.document_number, pedidos.material, pedidos.description, pedidos.`ordered quantit`, estado_pedidos.name, pedidos.date_of_sc, pedidos.new_date, pedidos.observaciones FROM pedidos INNER JOIN estado_pedidos ON pedidos.estado_pedido = (estado_pedidos.estado_pedido) WHERE pedidos.en_stock='0' AND pedidos.name LIKE '%".$nombre."%' AND pedidos.description LIKE '%".$descripcion."%' ORDER BY pedidos.date_of_sc";
           
            }
            else
            {
                $sql = "SELECT pedidos.supplier, pedidos.name as proveedor, pedidos.document_number, pedidos.material, pedidos.description, pedidos.`ordered quantit`, estado_pedidos.name, pedidos.date_of_sc, pedidos.new_date, pedidos.observaciones FROM pedidos INNER JOIN estado_pedidos ON pedidos.estado_pedido = (estado_pedidos.estado_pedido) WHERE pedidos.en_stock='0' AND pedidos.name LIKE '%".$nombre."%' AND pedidos.description LIKE '%".$descripcion."%' AND supplier = ".$supp." ORDER BY pedidos.date_of_sc";
                
            }
            
            //Recibe respuesta
            $respuesta = mysqli_query($conexion, $sql);

            //PROCEDIMIENTO PARA GENERAR EL EXCEL EN BASE A LA CONSULTA ANTERIOR
            require_once 'Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            
            $rowCount = 1; 
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Supplier');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Proveedor');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Documento');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Material');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Descripción');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'Cantidad');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'Estado');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'Fecha esperada');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'Fecha informada');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'Observaciones');
            
            while($row = mysqli_fetch_array($respuesta)){ 
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['0']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['4']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['5']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['6']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['7']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['8']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['9']);
            } 
            

            $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);

            // Renombrar Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Listado de Pedidos');

            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('xls/listado.xlsx');

            //Cierra la conexión
            mysqli_close($conexion);

?>
    