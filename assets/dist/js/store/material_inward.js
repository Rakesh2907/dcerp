$(document).ready(function(){

});

function get_vendor(po_id){

  if(po_id > 0)
  {
	  		$.ajax({
				type: "POST",
				url: baseURL+'store/get_vendor_details',
				headers: { 'Authorization': user_token },
				cache: false,
				data: 'po_id='+po_id,
				beforeSend: function(){

				},
				success: function(result){

				}
   			});
  }	
				
}