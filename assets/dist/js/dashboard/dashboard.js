/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

/*$(document).ready(function () {
	
});*/

function requisation_more_info(){
	
	$.ajax({
       type: "POST",
       url: baseURL +"dashboard/get_requisation_details", 
       headers: { 'Authorization': user_token },
       cache:false, 
       
       beforeSend: function () {
       
       },
       success: function(result){
          $("#requisation_toggle").html('');
          $("#requisation_toggle").html(result);
       }
    });
}