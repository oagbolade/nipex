var button = document.getElementsByClassName("button");
var disapproveBtn = document.getElementById("disapproveBtn");
var reason = document.getElementById("reason");

for (var i=0; i < button.length; i++) {
  button[i].addEventListener('click', changeStatus, false);
}

function changeStatus(){
	if(this.value == 'approve'){
		reason.disabled = true;
		reason.required = false;
		reason.placeholder = "";
	}
	else{
		reason.disabled = false;
		reason.required = true;
		reason.placeholder = "Please specify the reason";
	}
}

