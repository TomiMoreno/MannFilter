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
            $rojo = 0;
            $amarillo = 0;
            $contador = 0;
            //Consulta y filtra por columna "document_number", además filtra también por proveedor y material
            //CONSULTA INTERMINABLE DONDE TRAE LOS ESTADOS DE LOS PEDIDOS DESTE LA TABLA
            //ESTADO_PEDIDOS. DE ESTA MANERA LOS ESTADOS YA NO QUEDAN HARDCODEADOS
            //CORRECIÓN DE LA QUERY DE PEDIDOS
            if($supp=="0")
            {
                $sql = "SELECT pedidos.supplier, pedidos.name as proveedor, pedidos.document_number, pedidos.material, pedidos.description, pedidos.`ordered quantit`, estado_pedidos.name, pedidos.date_of_sc, pedidos.new_date, pedidos.observaciones, pedidos.fecha_alta, pedidos.dias_fijo, pedidos.devolucion FROM pedidos INNER JOIN estado_pedidos ON pedidos.estado_pedido = (estado_pedidos.estado_pedido) WHERE pedidos.en_stock=0 AND pedidos.name LIKE '%".$nombre."%' AND pedidos.material LIKE '%".$descripcion."%' ORDER BY pedidos.date_of_sc";
                
            }
            else
            {
                $sql = "SELECT pedidos.supplier, pedidos.name as proveedor, pedidos.document_number, pedidos.material, pedidos.description, pedidos.`ordered quantit`, estado_pedidos.name, pedidos.date_of_sc, pedidos.new_date, pedidos.observaciones, pedidos.fecha_alta, pedidos.dias_fijo, pedidos.devolucion FROM pedidos INNER JOIN estado_pedidos ON pedidos.estado_pedido = (estado_pedidos.estado_pedido) WHERE pedidos.en_stock=0 AND pedidos.name LIKE '%".$nombre."%' AND pedidos.material LIKE '%".$descripcion."%' AND supplier = ".$supp." ORDER BY pedidos.date_of_sc";
                
            }
            
            //Envía respuesta
            $respuesta = mysqli_query($conexion, $sql);
            $numero = mysqli_num_rows($respuesta);
            //Creación de tabla
            
            //****************CALCULO DEL BACK ORDER DE FORMA DINAMICA****************/
            $hoy = date("Y-m-d");
                
            while($row = mysqli_fetch_array($respuesta)){
                $sqlhorizonte = "SELECT fecha FROM calendario WHERE fecha BETWEEN '".$hoy."' AND '".$row['date_of_sc']."' AND observaciones=''";
                //Envía respuesta
                $horizonte = mysqli_query($conexion, $sqlhorizonte);
                $cant_dias = mysqli_num_rows($horizonte);
               
                
                //SI LA FECHA ESTÁ ATRASADA, VA EN ROJO
                if($hoy>$row['date_of_sc'])
                {

                    $rojo=$rojo + $row['ordered quantit'];

                }
                else
                {

                    
                    if($cant_dias<=$row['dias_fijo'])
                    {
                        $amarillo=$amarillo + $row['ordered quantit'];
                    
                    }


                }
                
                $contador = $contador + 1;
            }
                
            $backorder = round(($rojo/($rojo+$amarillo))*100,2);



            /*************************************************************************/

            //Envía respuesta
            $respuesta = mysqli_query($conexion, $sql);
            $numero = mysqli_num_rows($respuesta);
            //Creación de tabla


            //*************** MODIFICADO POR PCR ****************
            echo "<h1>Back Order: ".$backorder."%</h1>";
            echo "Se han encontrado ".$numero." pedidos pendientes ";
            echo "<button class='exportar' id='exportar' type='button' onclick='exportList()'>EXPORTAR A EXCEL</button>";
            echo"<table id='listado'>
                <tr>
                <th> Supplier </th>
                <th> Proveedor </th>
                <th> Documento </th>
                <th> Material </th>
                <th> Descripción </th>
                <th> Cantidad </th>
                <th> Estado </th>
                <th> Fecha esperada </th>
                <th> Fecha informada </th>
                <th> Observaciones </th>
                </tr>";
            //creamos una variable para enviar a validarEstado
            $contador = 1;

           
            //Coloca los datos en la tabla --- SE AGREGARON UTF8 ENCODE PARA EVITAR CARACTERES RAROS
            $hoy = date("Y-m-d");
        
            while($row = mysqli_fetch_array($respuesta)){
                echo "<tr>";
                echo "<td>" .$row['supplier'] . "</td>";
                echo "<td>" .utf8_encode($row['proveedor']) . "</td>";
                echo "<td>" .$row['document_number'] . "</td>";
                echo "<td>" .$row['material'] . "</td>";
                echo "<td>" .$row['description'] ."</td>";
                echo "<td>" .$row['ordered quantit'] . "</td>";
                echo "<td>" .utf8_encode($row['name']) . "</td>";
        
                //*********************MODIFICADO POR PCR************************/
                $sqlhorizonte = "SELECT fecha FROM calendario WHERE fecha BETWEEN '".$hoy."' AND '".$row['date_of_sc']."' AND observaciones=''";
                //Envía respuesta
                $horizonte = mysqli_query($conexion, $sqlhorizonte);
                $cant_dias = mysqli_num_rows($horizonte);
               
                
                //SI LA FECHA ESTÁ ATRASADA, VA EN ROJO
                if($hoy>$row['date_of_sc'])
                {

                    echo "<td class='rojo'>" .$row['date_of_sc'] . "</td>";
                    $rojo=$rojo + $row['ordered quantit'];

                }
                else
                {

                    if($cant_dias>$row['dias_fijo'])
                    {
                        echo "<td class='verde'>" .$row['date_of_sc'] ."</td>";
                    
                    }

                    
                    if($cant_dias<=$row['dias_fijo'])
                    {
                        echo "<td class='amarillo'>" .$row['date_of_sc'] . "</td>";
                        $amarillo=$amarillo + $row['ordered quantit'];
                    
                    }


                }
                
       

                //*******************************************************************************************
                
                
                echo "<td>" .$row['new_date']. "</td>";
                echo "<td>"  .$row['observaciones'].  "</td>";
                //*******************************************************************************************

                echo "</tr>";
                //Incrementamos de a uno el contador
                $contador = $contador + 1;
            }
                echo "</table>";

                $backorder = round(($rojo/($rojo+$amarillo))*100,2);

                // inicializar las variables de sesión
                $_SESSION['BackOrder'] = $backorder;
                
                    
            //****************************************************
        
            //Cierra la conexión
            mysqli_close($conexion);
        ?>
    