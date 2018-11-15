let hidden = false;
let management_hidden = false;

// If NO is selected in database, Hide on page load
hideOnLoad = ()=>{
    let nigeriaContentRadio = document.getElementsByName('nigeriaContent');
    let hsePolicyRadio = document.getElementsByName('hsePolicy');
    let managementSystemRadio = document.getElementsByName('managementSystem');
      for (var i = 0, length = hsePolicyRadio.length; i < length; i++){
        if(hsePolicyRadio[i].checked && hsePolicyRadio[i].value == 'No'){
          document.getElementById('hide').style.display = 'none';
          hidden = true;
          break;
        }
      }

      for (var i = 0, length = nigeriaContentRadio.length; i < length; i++){
        if (nigeriaContentRadio[i].checked && nigeriaContentRadio[i].value == 'no'){
          document.getElementById('hide').style.display = 'none';
          hidden = true;
          break;
        }
      }

      for (var i = 0, length = managementSystemRadio.length; i < length; i++){
        if (managementSystemRadio[i].checked && managementSystemRadio[i].value == 'No'){
          let managementClasses = document.getElementsByClassName('hide_management');
          for (let i = 0; i < managementClasses.length; i++) {
            managementClasses[i].style.display = 'none';
          }
          management_hidden = true;
          break;
        }
      }
}
hideOnLoad();

hideContent = (management = false) =>{
    if(management_hidden === false && management === 'true'){
      $('.hide_management').fadeOut('slow');
      $('.hide_management *').prop('disabled', true);
      management_hidden = true;
    }

    if(hidden === false && management === false){
      $('#hide').fadeOut('slow');
      $('#hide *').prop('disabled', true);
      hidden = true;
    }
  }

showContent = (management = false) =>{
    if(hidden === true && management === false){
      $('#hide').fadeIn('slow');
      $('#hide *').prop('disabled', false);
      hidden = false;
    }

    if(management_hidden === true && management === 'true'){
      $('.hide_management').fadeIn('slow');
      $('.hide_management *').prop('disabled', false);
      management_hidden = false;
    }
}
