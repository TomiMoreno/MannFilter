const boton = document.getElementById("ingreso");

//AL DETECTAR MOVIMIENTO DEL MOUSE, HABILITA LA VALIDACIÓN
function deshabilitar(){
        boton.disabled = true;
}

function validar(){
        boton.disabled = false;
}

