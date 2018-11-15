var addBtn = document.getElementById('al_op_executive_btn');
var table = document.getElementsByClassName('al_op_executive');
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
	var btnNames = ['executivePosition', 'executiveTitle', 'executiveFirstName', 'executiveOtherName', 'executiveSurname', 'executiveEmail', 'executiveNationality', 'deleteBtn'];
	var post =  ['Finance Director', 'Sales/Marketing Manager', 'Technical/Ops Manager', 'Procurement Director', 'Others'];
	var tableData, input, option;
	for (var i=0; i < btnNames.length; i++) {
		tableData = document.createElement("td");
		if(btnNames[i] == 'deleteBtn'){
			var deleteBtn = document.createElement('a');
			deleteBtn.className = "al_delete_btn btn btn-sm btn-danger";
			deleteBtn.type = "button";
			deleteBtn.href = "#companyExecutives";
			deleteBtn.innerHTML = "X";
			deleteBtn.setAttribute("data-row", "row"+rowCounter);
			deleteBtn.addEventListener('click', deleteRow, false);
			input = deleteBtn;
		}
		else if(btnNames[i] == 'executivePosition'){
			select = document.createElement('select');
			select.className = "form-control";
			select.required = "required";
			select.name = btnNames[i]+"[]";
			var firstOption = document.createElement('option');
			firstOption.value = "";
			firstOption.innerHTML = "Pick a Position";
			select.appendChild(firstOption);
			for (var k=0; k < post.length; k++) {
				option = document.createElement('option');
				option.value = post[k];
				option.innerHTML = post[k];
				select.appendChild(option);
				input = select;
			}
		}
		else{
			input = document.createElement('input');
			if(btnNames[i] == 'executiveEmail'){
				input.type = "email";
			}
			else{
				input.type = "text";
			}
			if(btnNames[i] != 'executiveOtherName') input.required = "required";
			input.className = "form-control";
			input.name = btnNames[i]+"[]";
		}
		tableData.appendChild(input);
		tableRow.appendChild(tableData);
	}
	table[0].appendChild(tableRow);
	++rowCounter;
} 