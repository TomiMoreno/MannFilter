 var validado=false;


//AL DETECTAR MOVIMIENTO DEL MOUSE, HABILITA LA VALIDACIÓN
function habilitar(){
    validado = true;

}

function validar(){

    if(validado == true){
        var boton = document.getElementById("ingreso");
        boton.disabled = false;

    }

}

