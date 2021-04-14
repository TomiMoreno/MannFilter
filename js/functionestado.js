

//****************** MODIFICADO POR PCR **********************/

function seleccionarEstado(indice){ 

    var miSelect = document.getElementById(indice).value;

    var combo = document.getElementById(indice);

    var selected = combo.options[combo.selectedIndex].value;

   



    //armamos el ID inX mediante concatenación entre in y el indice recibido

    var prefijo = "in";

    var cadena = prefijo.concat(indice.toString());



    var prefijo2 = "obs";

    var cadena2 = prefijo2.concat(indice.toString());



    var input = document.getElementById(cadena).disabled=true;

    var observaciones=document.getElementById(cadena2).disabled=true;



    validarEstado(indice);

      
}   

//************************************************************/



//****************** MODIFICADO POR PCR **********************/

function validarEstado(indice){

    

    //armamos el ID inX mediante concatenación entre in y el indice recibido

    var prefijo = "in";

    var cadena = prefijo.concat(indice.toString());

    var prefijo2 = "obs";

    var cadena2 = prefijo2.concat(indice.toString());

    

    var documento=document.getElementById("listado").rows[indice].cells[0].innerHTML;

    var material=document.getElementById("listado").rows[indice].cells[1].innerHTML;

    var fecha=document.getElementById("listado").rows[indice].cells[4].innerHTML; //fecha actual

    var observaciones=document.getElementById(cadena2).value; 

    var nueva_fecha=document.getElementById(cadena).value; //fecha prevista

    var estado=document.getElementById(indice).value;

    

    /*DEJAR COMENTADO POR SI HAY QUE DEPURAR ALGÚN DÍA

    console.log(documento);

    console.log(material);

    console.log(fecha);

    console.log(nueva_fecha);

    console.log(estado);

    console.log(observaciones);

    */



    var xmlhttp = new XMLHttpRequest();


    //Este form data envia los datos por medio de POST

    var data = new FormData();

    //Agregamos los atributos

    data.append('document_number', documento);

    data.append('material', material);

    data.append('date_of_sc', fecha);

    data.append('date_of_sc_n',nueva_fecha); //enviamos la nueva fecha de entrega prevista

    data.append('status', estado);

    data.append('observaciones', observaciones);

    

    xmlhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

            //document.getElementById("estadoSeleccionado").innerHTML = this.responseText;
            var resultado = this.responseText;
            console.log(resultado);
            if(resultado==0)
            {
                    var input = document.getElementById(cadena).disabled=true;

                    var observaciones=document.getElementById(cadena2).disabled=true;
            }
            if(resultado==1)
            {
                    var input = document.getElementById(cadena).disabled=true;

                    var observaciones=document.getElementById(cadena2).disabled=false;
            }
            if(resultado==2)
            {       var input = document.getElementById(cadena).disabled=false;

                    var observaciones=document.getElementById(cadena2).disabled=true;
            }   
            if(resultado==3)
            {
                    var input = document.getElementById(cadena).disabled=false;

                    var observaciones=document.getElementById(cadena2).disabled=false;
            }

        }

    };



    //Envía mediante POST a PHP, los datos que se necesitan buscar

    xmlhttp.open("POST", "updatelist.php", true);

    //Carga los datos del POST

    xmlhttp.send(data);



}

//************************************************************/



//****************** MODIFICADO POR PCR **********************/

function validarEstadoAdmin(indice){ 

    

    var documento=document.getElementById("listado").rows[indice].cells[1].innerHTML;

    var material=document.getElementById("listado").rows[indice].cells[2].innerHTML;

    var fecha=document.getElementById("listado").rows[indice].cells[6].innerHTML; //fecha actual





    var xmlhttp = new XMLHttpRequest();



    //Este form data envia los datos por medio de POST

    var data = new FormData();

    //Agregamos los atributos

    data.append('document_number', documento);

    data.append('material', material);

    data.append('date_of_sc', fecha);

    

    xmlhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

           // document.getElementById("estadoSeleccionado").innerHTML = this.responseText;

        }

    };



    //Envía mediante POST a PHP, los datos que se necesitan buscar

    xmlhttp.open("POST", "updatelistadmin.php", true);

    //Carga los datos del POST

    xmlhttp.send(data);



    alert("ESTADO DE MATERIAL ACTUALIZADO");



}

//************************************************************/