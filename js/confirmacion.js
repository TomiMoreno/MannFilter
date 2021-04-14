function confirmacion(e) {
	var opcion = confirm("¿Esta seguro que desea eliminar este usuario?");
	if (opcion == true) {
		return true;
	} else {
		e.preventDefault();
	}	
}

let linkDelete = document.querySelectorAll(".link_item_delete");
for (var i = 0; i < linkDelete.length; i++) {
	linkDelete[i].addEventListener('click', confirmacion);
}