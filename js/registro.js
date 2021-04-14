function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("tipous").value;
/* Para validar que se muestre el campo supplier  */
var combo = document.getElementById("tipous");
var selected = combo.options[combo.selectedIndex].value;
var supplier = document.getElementById("elementoOcult");
if (selected == 0) {
	supplier.style.display = "block" } 
	else {
	var supplier = document.getElementById("elementoOcult");
	supplier.style.display = "none"	}
}	