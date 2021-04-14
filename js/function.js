
function loadList(valor){
    /*Declaración de variables XMLHttpRequest (AJAX), utilizamos este método para no tener que recargar 
    la página cada vez que queramos agregar una funcion o cargar un dato. La otra variable representa el código de proveedor*/
    var xmlhttp = new XMLHttpRequest();
    //Este form data envia los datos por medio de POST
    var data = new FormData();        
    data.append('ordenador', valor);
    /*Cuando se produce un cambio dentro del AJAX, se ejecuta la función donde el readyState declara el estado del pedido, 
    en este caso 4 es terminado, y el status declara el estado de la respuesta al pedido, en este caso 200 es exitoso.
    Básicamente pregunta si el pedido se completó y si fué exitoso */
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("listArea").innerHTML = this.responseText;
        }
    };
    //Envía mediante POST a PHP, los datos que se necesitan buscar
    xmlhttp.open("POST", "getlist.php", true);
    //Carga los datos del POST
    xmlhttp.send(data);
}
