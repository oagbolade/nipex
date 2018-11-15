var form =  document.getElementById("form");
  var newEle =  document.getElementById("newEle");
  button.addEventListener("click", createTags, false);
  var num = 0;
  function createTags() {
    num++;
    var newInputTag, newDiv, innerDiv;
    var controlType = ['text', 'text', 'number', 'file'];
    var controlName = ["school[]", "qualification[]", "year[]", "certificate[]"];
    newDiv = document.createElement("div");
    newDiv.setAttribute("class", "form-group col-md-12");
    
    for (var i = 0; i < 4; i++) {
      newInputTag = document.createElement("input");
      innerDiv = document.createElement("div");
      newInputTag.setAttribute("type", controlType[i]);
      newInputTag.setAttribute("class", "form-control");
      newInputTag.setAttribute("name", controlName[i]);
      innerDiv.setAttribute("class", "col-md-3 col-sm-6 col-xs-12");
      innerDiv.appendChild(newInputTag);
      newDiv.appendChild(innerDiv);
    }
    form.insertBefore(newDiv, newEle);
  }

	var formBody =  document.getElementById("formBody");
  var newEleBody =  document.getElementById("newEleBody");
  buttonBody.addEventListener("click", createBodyTags, false);
  var numBody = 0;
  function createBodyTags() {
    numBody++;
    var newInputTag, newDiv, innerDiv;
    var controlType = ['text', 'text', 'number', 'file'];
    var controlName = ['body[]', 'bodyQua[]','bodyYear[]', 'bodyCertificate[]'];
    newDiv = document.createElement("div");
    newDiv.setAttribute("class", "form-group col-md-12");
    
    for (var i = 0; i < 4; i++) {
      newInputTag = document.createElement("input");
      innerDiv = document.createElement("div");
      newInputTag.setAttribute("type", controlType[i]);
      newInputTag.setAttribute("class", "form-control");
      newInputTag.setAttribute("name", (controlName[i]));
      innerDiv.setAttribute("class", "col-md-3 col-sm-6 col-xs-12");
      innerDiv.appendChild(newInputTag);
      newDiv.appendChild(innerDiv);
    }
    formBody.insertBefore(newDiv, newEleBody);
  }