<?php
    session_start();
    
?>

<html>
    <head>
    <meta charset="UTF-8"> <!-- corregir los caracteres con UTF-8 -->
    <script type="text/javascript" language="Javascript">
            document.oncontextmenu = function(){return false}   
        </script>
        <link rel="shortcut icon" href="img/logo.jpg">
        <link rel="stylesheet" type="text/css" href="css/tablas.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/textos.css">

        <script src="js/functionestado.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT E IBA EN EL HEAD -->
        <script src="js/verpedidos.js" type="text/javascript"></script> <!--FALTABA TEXT/JAVASCRIPT -->
    </head>
    <body>
        <span id="estadoSeleccionado"></span>

        <!-- ***************************** !-->
        <br> <br>
        <form action="pedidos.php">
            <button type="submit" class="button1">Volver a la pagina principal</button>
        </form>
        <?php
            //Conexión con la base de datos
            include 'conexion.php';
            //Declaro la variable mediante POST
            $supplier = $_SESSION['supplier'];
            //echo $supplier; es a modo de debug

            //****** ESTO ES PARA ORDENAR LAS COLUMNAS ****////
            $order="";

            if (isset($_GET['columna'])) {
                $order = " order by " .$_GET['columna']." ".$_GET['tipo']; 
            }   

            //***************************************************
            
            //*************** MODIFICADO POR PCR ******************
            //TRAIGO EL NOMBRE DEL PROVEEDOR
            $rojo = 0; //contador de pedidos en rojo
            $amarillo = 0; //contador de pedidos en amarillo

            $sql = "SELECT name FROM pedidos WHERE supplier = '".$supplier."' LIMIT 1";
            //Envía respuesta
            $respuesta = mysqli_query($conexion, $sql);
            $row = mysqli_fetch_array($respuesta);

            //mostramos el porcentaje de cumplimiento el proveedor y ponemos un enlace para ver el detalle
            //$sql = "SELECT cumplimiento FROM estadisticaprov WHERE supplier = '".$supplier."' LIMIT 1";
            //Envía respuesta
            //$respuesta = mysqli_query($conexion, $sql);
            //$cumplimiento = mysqli_fetch_array($respuesta);

            echo "<h1>" .$row[0]. " - Lista de productos</h1>";
            echo "<br>";
            echo "<div id='info'></div>";
            echo "<br>";
            
            //******************************************************

            //Consulta y filtra por columna "document_number"
            $sql = "SELECT pedidos.*,(estado_pedidos.name)AS estado FROM pedidos INNER JOIN estado_pedidos ON pedidos.estado_pedido = (estado_pedidos.estado_pedido) WHERE supplier = ".$supplier." AND (en_stock=0 OR en_stock=3) $order;";
            $sqlestado = "SELECT * FROM estado_pedidos WHERE status = 0 ORDER BY Id DESC";
            //Envía respuesta
            $respuestaestados = mysqli_query($conexion, $sqlestado);
            $numero_estados = mysqli_num_rows($respuestaestados);
            
            $i = 0;
            while($rowestado = mysqli_fetch_array($respuestaestados)){
                $cod_estados[$i]=$rowestado['estado_pedido'];
                $desc_estados[$i]=$rowestado['name'];
                $campo_obs[$i]=$rowestado['campo_obs'];
                $campo_date[$i]=$rowestado['campo_date'];
                $i++;

            }

            $respuesta = mysqli_query($conexion, $sql);
            $numero = mysqli_num_rows($respuesta);
            //Creación de tabla

            
            //*************** MODIFICADO POR PCR ******************
            $columna = isset($_GET['columna'])?$_GET['columna']:null;
            $tipo = isset($_GET['tipo'])?$_GET['tipo']:null;
            echo "Se han encontrado ".$numero." pedidos pendientes";
            echo "<button class='exportar' id='exportar' type='button' onclick='exportListProv(\"".$sql."\")'>EXPORTAR A EXCEL</button>"; //para exportar pedidos
            echo"<table id='listado'>
                <tr>
                <th> Documento </th>
                <th> Material<br>"; ordenador($columna, 'material', $tipo);
            echo"</th>
                <th> Descripción<br>"; ordenador($columna, 'description', $tipo);
            echo"</th>
                <th> Cantidad </th>
                <th> Fecha<br>"; ordenador($columna, 'date_of_sc', $tipo);
            echo"</th>
                <th> Estado </th>
                <th> Fecha esperada </th>
                <th> Observaciones </th>
                </tr>";

            //creamos una variable para enviar a validarEstado
            $contador = 1;

            //Coloca los datos en la tabla
            while($row = mysqli_fetch_array($respuesta)){
                echo "<tr>";
                echo "<td>" .$row['document_number'] . "</td>";
                echo "<td>" .$row['material'] . "</td>";
                echo "<td>" .$row['description'] ."</td>";
                echo "<td>" .$row['ordered quantit'] . "</td>";


                //*********************MODIFICADO POR PCR************************/
                $hoy = date("Y-m-d");
                $sqlhorizonte = "SELECT fecha FROM calendario WHERE fecha BETWEEN '".$hoy."' AND '".$row['date_of_sc']."' AND observaciones=''";
                //Envía respuesta
                $horizonte = mysqli_query($conexion, $sqlhorizonte);
                $cant_dias = mysqli_num_rows($horizonte);
                

                //SI LA FECHA ESTÁ ATRASADA, VA EN ROJO
                if($hoy>$row['date_of_sc'])
                {

                    echo "<td class='rojo'>" .$row['date_of_sc'] . "</td>";
                    //echo "<td class='rojo'>" .$fecha . "</td>";
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

                echo "<td><select id='".$contador."' onchange='seleccionarEstado(".$contador.")' class='comboEstados'>";
                
                //**********LEVANTAR LOS ESTADOS DESDE LA TABLA ESTADO_PEDIDOS***********/

                $i = 0;
                while($i<$numero_estados){
                    echo   "<option value='".$cod_estados[$i]."' ";
                    if($cod_estados[$i]==$row['estado_pedido']){
                        echo "selected";
                    }

                    echo ">".utf8_encode($desc_estados[$i])." - ".$cod_estados[$i]."";    
                    $i++;
    
                }
                echo "</select>";

               echo "</td>";
                //*******************************************************************/


                //*****ESTE SWITCH ES PARA QUE LOS COMBOS SE CARGUEN DE ACUERDO A LA TABLA DE PEDIDOS*****

                

                
                //***************************************************************************************
                echo "<td><input type='date' name='fech' id='in".(string)$contador."' value='".$row['new_date']."' disabled='true' onchange='validarEstado(".$contador.")'></td>"; //se cambió la fecha del input por la fecha del campo
                echo "<td><input type='text' id='obs".$contador."' onchange='validarEstado(".$contador.")' value='".$row['observaciones']."' disabled></td>";
                echo "</tr>";
                //Incrementamos de a uno el contador
                $contador = $contador + 1;
            
            }
                echo "</table>";

                $backorder = round(($rojo/($rojo+$amarillo))*100,2);

                echo "<script type='text/javascript'>document.getElementById('info').innerHTML = '<h1>Back Order: ".$backorder."%</h1>';</script>";


                //****************************************************
            
            ///////***********FUNCION PARA ORDENAR ASC O DESC **************///////////////
                function ordenador($columnaslec, $columnaValor, $tipoOrden) {
            ?>
            <?php if (isset($columnaslec) && $columnaslec == $columnaValor && $tipoOrden=='asc'): ?>
            <button type="button" disabled>Des</button>    
            <?php else: ?>  
            <a href="getlist.php?columna=<?php echo $columnaValor; ?>&tipo=asc"><button type="button">Des</button></a>
            <?php endif; ?>
            <?php if (isset($columnaslec) && $columnaslec == $columnaValor && $tipoOrden=='desc'): ?>
            <button disabled>Asc</button></a>
            <?php else: ?>
            <a href="getlist.php?columna=<?php echo $columnaValor; ?>&tipo=desc"><button>Asc</button></a>
            <?php endif; ?>
            <?php     }
            //************************************************************************
            //Cierra la conexión
            mysqli_close($conexion);
        ?>
    </body>
</html>