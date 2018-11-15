let al_op_hide = document.getElementsByClassName("al_op_hide");
let hsePolicy = document.getElementsByName("hsePolicy");
for (var i = 0; i < hsePolicy.length; i++) {
  hsePolicy[i].addEventListener("click", function () {
    if (this.value == "No") {
      dynamicElement(al_op_hide, "none");
    }else{
      dynamicElement(al_op_hide, "block");
    }
  }, false);
}
function dynamicElement(element, displayValue) {
  for (var i = 0; i < element.length; i++) {
     element[i].style.display = displayValue;
  }
}