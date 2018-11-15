var insuranceYes = document.getElementById("insuranceYes");
var insuranceNo = document.getElementById("insuranceNo");
var fields = document.getElementsByClassName("jsHandle");

insuranceNo.addEventListener('click', disableFields, false);
insuranceYes.addEventListener('click', enableFields, false);

function disableFields(){
	for(var i = 0; i < fields.length; i++){
		fields[i].disabled = true;
		fields[i].value = "";
	}
}

function enableFields(){
	for(var i = 0; i < fields.length; i++){
		fields[i].disabled = false;
	}
}
