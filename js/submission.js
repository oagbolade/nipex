var appelation = document.getElementsByName("title");
var otherTitle = document.getElementsByClassName("other-title");

var offence = document.getElementsByName("offence");
var offenceStory = document.getElementsByClassName("offence-story");

var crime = document.getElementsByName("crime");
var crimeStory = document.getElementsByClassName("crime-story");

var i, appelationLength = appelation.length, offenceLength = offence.length, crimeLength = crime.length;
var i, offenceLength = offence.length, crimeLength = crime.length;

var objTitle = {
  theElements:appelation,
  theElementsLength:appelationLength,
  theElement:otherTitle,
  theDisplayNone:"display-none",
  theDisplayBlock:"display-block"
}
var objOffence = {
  theElements:offence,
  theElementsLength:offenceLength,
  theElement:offenceStory,
  theDisplayNone:"display-none",
  theDisplayBlock:"display-block"
}
var objCrime = {
  theElements:crime,
  theElementsLength:crimeLength,
  theElement:crimeStory,
  theDisplayNone:"display-none",
  theDisplayBlock:"display-block"
}
//dynamicDisplay(objTitle, "others");
dynamicDisplay(objOffence, "yes", offenceMsg);
dynamicDisplay(objCrime, "yes", crimeMsg);
function dynamicDisplay(obj, theValue, msg) {
  for (i = 0; i < obj.theElementsLength; i++) {
    obj.theElements[i].addEventListener("click", function () {
      if (this.value == theValue) {
        msg.setAttribute("required", "required");
        obj.theElement[0].classList.replace(obj.theDisplayNone, obj.theDisplayBlock);
      }else {
        msg.removeAttribute("required");
        obj.theElement[0].classList.replace(obj.theDisplayBlock, obj.theDisplayNone);
      }

    }, false);
  }
}
