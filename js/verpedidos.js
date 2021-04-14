   /*********************************MODIFICADO POR PCR********************************/
 
//ESTO ES PARA QUE LA TECLA ENTER NO NOS BORRE EL LISTADO
function capturaEnter(e){
    if (e.keyCode === 13) {
        e.preventDefault();
    }        
}
   /************************************************************************************/
 

function loadList(){
    /*Declaración de variables XMLHttpRequest (AJAX), utilizamos este método para no tener que recargar 
    la página cada vez que queramos agregar una funcion o cargar un dato. La otra variable representa el código de proveedor*/
    var xmlhttp = new XMLHttpRequest();

    /*********************************MODIFICADO POR PCR********************************/
    var supplier = document.getElementById("filtroSupp").value; //nombre del proveedor
    var nombre = document.getElementById("filtroProv").value; //nombre del proveedor
    var material = document.getElementById("filtroMat").value; //nombre del material
    
    //si el nombre está vacío, ponemos el comodín % para traer todo
    if(supplier==""){
        supplier="0";

    }
    
    //si el nombre está vacío, ponemos el comodín % para traer todo
    if(nombre==""){
        nombre="%";

    }

    //si el material está vacío, ponemos el comodín % para traer todo
    if(material==""){
        material = "%";

    }

    //Este form data envia los datos por medio de POST
    var data = new FormData();
    //Agregamos los atributos de nombre y material para filtrar los resultados
    data.append('supp', supplier); 
    data.append('name', nombre);
    data.append('description', material);

    /*Cuando se produce un cambio dentro del AJAX, se ejecuta la función donde el readyState declara el estado del pedido, 
    en este caso 4 es terminado, y el status declara el estado de la respuesta al pedido, en este caso 200 es exitoso.
    Básicamente pregunta si el pedido se completó y si fué exitoso */
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("listArea").innerHTML = this.responseText;
        }
    };
    //Envía mediante POST a PHP, los datos que se necesitan buscar
    xmlhttp.open("POST", "getlistpedidos.php", true);
    //Carga los datos del POST
    xmlhttp.send(data);
}


/* FUNCIÓN PARA EXPORTAR EL LISTADO DE ADMINISTRADOR A UN EXCEL */
function exportList(){
    /*Declaración de variables XMLHttpRequest (AJAX), utilizamos este método para no tener que recargar 
    la página cada vez que queramos agregar una funcion o cargar un dato. La otra variable representa el código de proveedor*/
    var xmlhttp = new XMLHttpRequest();

    /*********************************MODIFICADO POR PCR********************************/
    var supplier = document.getElementById("filtroSupp").value; //nombre del proveedor
    var nombre = document.getElementById("filtroProv").value; //nombre del proveedor
    var material = document.getElementById("filtroMat").value; //nombre del material
    var exportado = document.getElementById("exportar").innerText;

    if(exportado == "DESCARGAR EXCEL"){
        document.getElementById("exportar").innerHTML = "EXPORTAR A EXCEL";
    }
    else{


            //si el nombre está vacío, ponemos el comodín % para traer todo
        if(supplier==""){
            supplier="0";

        }
        
        //si el nombre está vacío, ponemos el comodín % para traer todo
        if(nombre==""){
            nombre="%";

        }

        //si el material está vacío, ponemos el comodín % para traer todo
        if(material==""){
            material = "%";

        }

        //Este form data envia los datos por medio de POST
        var data = new FormData();
        //Agregamos los atributos de nombre y material para filtrar los resultados
        data.append('supp', supplier); 
        data.append('name', nombre);
        data.append('description', material);

        /*Cuando se produce un cambio dentro del AJAX, se ejecuta la función donde el readyState declara el estado del pedido, 
        en este caso 4 es terminado, y el status declara el estado de la respuesta al pedido, en este caso 200 es exitoso.
        Básicamente pregunta si el pedido se completó y si fué exitoso */
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 1){
                document.getElementById("exportar").innerHTML = "EXPORTANDO...";
            
            }
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("exportar").innerHTML = "<a href='xls/listado.xlsx'>DESCARGAR EXCEL</a>";

            }
        };
        //Envía mediante POST a PHP, los datos que se necesitan buscar
        xmlhttp.open("POST", "exportlistpedidos.php", true);
        //Carga los datos del POST
        xmlhttp.send(data);

    }
    
    
}

/* FUNCIÓN PARA EXPORTAR EL LISTADO DE PROVEEDOR A UN EXCEL */
function exportListProv(consulta){
    /*Declaración de variables XMLHttpRequest (AJAX), utilizamos este método para no tener que recargar 
    la página cada vez que queramos agregar una funcion o cargar un dato. La otra variable representa el código de proveedor*/
    var xmlhttp = new XMLHttpRequest();

    /*********************************MODIFICADO POR PCR********************************/
    var exportado = document.getElementById("exportar").innerText;

    if(exportado == "DESCARGAR EXCEL"){
        document.getElementById("exportar").innerHTML = "EXPORTAR A EXCEL";
    }
    else{

        //Este form data envia los datos por medio de POST
        var data = new FormData();
        //Agregamos los atributos de nombre y material para filtrar los resultados
        data.append('consulta', consulta); 

        /*Cuando se produce un cambio dentro del AJAX, se ejecuta la función donde el readyState declara el estado del pedido, 
        en este caso 4 es terminado, y el status declara el estado de la respuesta al pedido, en este caso 200 es exitoso.
        Básicamente pregunta si el pedido se completó y si fué exitoso */
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 1){
                document.getElementById("exportar").innerHTML = "EXPORTANDO...";
            
            }
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("exportar").innerHTML = "<a href='xls/listadoProv.xlsx'>DESCARGAR EXCEL</a>";

            }
        };
        //Envía mediante POST a PHP, los datos que se necesitan buscar
        xmlhttp.open("POST", "exportlistpedidosProv.php", true);
        //Carga los datos del POST
        xmlhttp.send(data);

    }
    
    
}

