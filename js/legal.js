var addBtn = document.getElementById('al_op_ownership_btn');
var table = document.getElementsByClassName('al_op_ownership');
var rowCounter = 1;

addBtn.addEventListener('click', createRow, false);

function deleteRow(){
	var rowNo, row;
	rowNo = this.getAttribute("data-row");
	row = document.getElementById(rowNo);
	row.parentNode.removeChild(row);
}

function createRow(){
	var tableRow = document.createElement("tr");
	tableRow.id = "row"+rowCounter;
	var btnNames = ['director', 'nationality', 'gender', 'ownership', 'deleteBtn'];
	var tableData, input;
	for (var i=0; i < btnNames.length; i++) {
		tableData = document.createElement("td");
		if(btnNames[i] == 'deleteBtn'){
			var deleteBtn = document.createElement('a');
			deleteBtn.className = "al_delete_btn btn btn-sm btn-danger";
			deleteBtn.type = "button";
			deleteBtn.href = "#companyOwner";
			deleteBtn.innerHTML = "X";
			deleteBtn.setAttribute("data-row", "row"+rowCounter);
			deleteBtn.addEventListener('click', deleteRow, false);
			input = deleteBtn;
		}
		else{
			input = document.createElement('input');
			input.type = "text";
			if(btnNames[i] == 'ownership') input.type = "number";
			input.required = "required";
			input.className = "form-control";
			input.name = btnNames[i]+"[]";
		}
		tableData.appendChild(input);
		tableRow.appendChild(tableData);
	}
	table[0].appendChild(tableRow);
	++rowCounter;
}