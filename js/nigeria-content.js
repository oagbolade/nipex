let al_op_disable = document.getElementsByClassName("al_op_disable");
let al_op_hide = document.getElementsByClassName("al_op_hide");
let nigeriaContent = document.getElementsByName("nigeriaContent");
for (var i = 0; i < nigeriaContent.length; i++) {
  nigeriaContent[i].addEventListener("click", function () {
    if (this.value == "no") {
      // disableInputElement(al_op_disable, "disabled");
      hideElement(al_op_hide, "none");
    }else{
      // enableInputElement(al_op_disable);
      hideElement(al_op_hide, "block");
    }
  }, false);
}
/*
function disableInputElement(element, attributeValue) {
  for (var i = 0; i < element.length; i++) {
    element[i].setAttribute("disabled", attributeValue);
  }
}
function enableInputElement(element) {
  for (var i = 0; i < element.length; i++) {
    element[i].removeAttribute("disabled");
  }
}
*/
function hideElement(element, displayValue) {
  for (var i = 0; i < element.length; i++) {
     element[i].style.display = displayValue;
  }
}