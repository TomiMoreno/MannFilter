 var validado=false;


//AL DETECTAR MOVIMIENTO DEL MOUSE, HABILITA LA VALIDACIÓN
function deshabilitar(){
        var boton = document.getElementById("ingreso");
        console.log("hola");
        boton.disabled = true;

}

function validar(){

        var boton = document.getElementById("ingreso");
        console.log("chau");
        boton.disabled = false;

}

