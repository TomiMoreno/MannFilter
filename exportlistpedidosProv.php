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
            $consulta = $_POST['consulta'];

            
            //Recibe respuesta
            $respuesta = mysqli_query($conexion, $consulta);


            
            //PROCEDIMIENTO PARA GENERAR EL EXCEL EN BASE A LA CONSULTA ANTERIOR
            require_once 'Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            
            $rowCount = 1; 
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Documento');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Material');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Descripción');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Cantidad');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Fecha');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'Estado');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'Horizonte');
            
            while($row = mysqli_fetch_array($respuesta)){ 
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['5']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['6']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['7']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['9']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['20']);

                //*********************MODIFICADO POR PCR************************/
                $hoy = date("Y-m-d");
                $sqlhorizonte = "SELECT fecha FROM calendario WHERE fecha BETWEEN '".$hoy."' AND '".$row['date_of_sc']."' AND observaciones=''";
                //Envía respuesta
                $horizonte = mysqli_query($conexion, $sqlhorizonte);
                $cant_dias = mysqli_num_rows($horizonte);
                

                //SI LA FECHA ESTÁ ATRASADA, VA EN ROJO
                if($hoy>$row['date_of_sc'])
                {

                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Vencido");

                }
                else
                {

                    if($cant_dias>$row['dias_fijo'])
                    {
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Extendido");
                    
                    }

                    
                    if($cant_dias<=$row['dias_fijo'])
                    {
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Fijo");

                    }


                }


            } 
            

            $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);

            // Renombrar Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Listado de Pedidos');

            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('xls/listadoProv.xlsx');

            //Cierra la conexión
            mysqli_close($conexion);

?>
    