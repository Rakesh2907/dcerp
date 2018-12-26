$(document).ready(function () {
	 $("#master-unit").on('click',function(){
          console.log('unit');
     });
  
   $("#dashboard_home").on('click',function(){
        location.reload();
   });

   $("#more_info_req").trigger('click');
   if(prevent_f12 == '1'){
    	 $(document).keydown(function (event) {
                  if (event.keyCode == 123) { // Prevent F12
                      return false;
                  } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
                      return false;
                  }
       });
    } 

   if(prevent_right_click == '1'){ 
         $(document).on("contextmenu", function (e) {        
                   e.preventDefault();
         });
   }  
});