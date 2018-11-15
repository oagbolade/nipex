var addBtn = document.getElementById('createUpload');
var fileInputs = document.getElementsByClassName('upload');
var fileName = document.getElementsByClassName('document');
var newRow = document.getElementById('newRow');
var kanter = 1;

addBtn.addEventListener('click', createRow, false);

for (var i=0; i < fileInputs.length; i++) {
	fileInputs[i].addEventListener('change', requiredName, false);
}

for (var i=0; i < fileName.length; i++) {
	fileName[i].addEventListener('change', requiredFile, false);
}

function requiredFile(){
	var filenameNo = this.id.substring(8);
	var uploadNo = "upload"+filenameNo;
	if(this.value){
		document.getElementById(uploadNo).required = 'required';	
	}
	else{
		document.getElementById(uploadNo).required = false;
	}
	
}

function requiredName(){
	var uploadNo = this.id.substring(6);
	var documentNo = "document"+uploadNo;
	document.getElementById(documentNo).required = 'required';
}

function deleteRow(){
	var rowNo, row;
	rowNo = this.getAttribute("data-row");
	row = document.getElementById(rowNo);
	row.parentNode.removeChild(row);
}

function createRow(){
	var divRow = document.createElement("div");
	divRow.id = "row"+kanter;
	divRow.className = "row form-group";
	
	var colSM4Row = document.createElement("div");
	colSM4Row.className = "col-sm-4";
	var documentInput = document.createElement("input");
	documentInput.className = "form-control";
	documentInput.name = "document[]";
	documentInput.id = "document"+kanter;
	documentInput.type = "type";
	documentInput.placeholder = "name of document";
	documentInput.addEventListener('change', requiredFile, false);
	colSM4Row.appendChild(documentInput);
	divRow.appendChild(colSM4Row);
	
	var colSM8Row = document.createElement("div");
	colSM8Row.className = "col-sm-7";
	var uploadInput = document.createElement("input");
	uploadInput.className = "form-control";
	uploadInput.name = "upload[]";
	uploadInput.id = "upload"+kanter;
	uploadInput.type = "file";
	uploadInput.addEventListener('change', requiredName, false);
	colSM8Row.appendChild(uploadInput);
	divRow.appendChild(colSM8Row);
	//type="" id="createUpload" class=""
	var colSM1Row = document.createElement("div");
	colSM1Row.className = "col-sm-1";
	var delButton = document.createElement("button");
	delButton.className = "btn btn-danger";
	delButton.type = "button";
	delButton.setAttribute("data-row", "row"+kanter);
	delButton.innerHTML="X";
	delButton.addEventListener('click', deleteRow, false);
	colSM1Row.appendChild(delButton);
	divRow.appendChild(colSM1Row);
	
	newRow.appendChild(divRow);
	
	++kanter;
}