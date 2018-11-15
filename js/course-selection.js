var membership = document.getElementById('membership');
var course = document.getElementById('course');
noCourse();
membership.addEventListener('change', changeCouse, false);

function changeCouse(){
	if(membership.value == 'member1') formChecbox(member1);
	if(membership.value == 'member2') formChecbox(member2);
	if(membership.value == 'member3') formChecbox(member3);
	if(membership.value == 'member4') formChecbox(member4);
	if(!membership.value) noCourse();
}

function noCourse(){
	course.innerHTML = "";
}

function formChecbox(listOfCourse){
	noCourse();
	var aCheckBox, aSpan, aSpanText;
	for (var i=0; i < listOfCourse.length; i++) {
		aCheckBox = document.createElement('input');
		aCheckBox.type = 'checkbox';
		aCheckBox.className = 'al_course_input';
		aCheckBox.name = 'course[]';
		aCheckBox.value = listOfCourse[i];
		course.appendChild(aCheckBox);
		aSpan = document.createElement('span');
		aSpan.className = 'al_course_name';
		aSpanText = document.createTextNode(listOfCourse[i]);
		aSpan.appendChild(aSpanText);
		course.appendChild(aSpan);
	}
}
