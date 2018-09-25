$(document).ready(function () {
	 $("#master-unit").on('click',function(){
          console.log('unit');
     });
  
   $("#dashboard_home").on('click',function(){
        location.reload();
   });

   $("#more_info_req").trigger('click');
	 /*$(document).keydown(function (event) {
              if (event.keyCode == 123) { // Prevent F12
                  return false;
              } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
                  return false;
              }
     });

     $(document).on("contextmenu", function (e) {        
               e.preventDefault();
     });*/
     
});