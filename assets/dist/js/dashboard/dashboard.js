/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */
function session_expire(){
    $.ajax({
        url: baseURL +'commonrequesthandler_ui/session_expire_timeout',
        headers: { 'Authorization': user_token },
        contentType:false,
        cache:false,
        processData:false,
        beforeSend: function (){

        },
        success: function(result, status, xhr) {
            var res = JSON.parse(result);
            if(res.status == 'success'){
              var expire_time = res.sess_expire;

              myexpVar= setInterval(function(){ 
                                  if(expire_time>=0){
                                        $("#session_expire_in").html(getTime(expire_time));
                                  }
                                  expire_time--;

                                  if(expire_time==0){
                                      $("#session_expire_timeout").modal({backdrop: 'static', keyboard: false});
                                  }             
              }, 1000);

            }else if(res.status == 'error'){
                swal({
                  title: "",
                  text: res.message,
                  type: "error",
                });
            }
        }                             
    });
} 

function check_notification(){
    $.ajax({
        url: baseURL +'commonrequesthandler_ui/check_notification',
        headers: { 'Authorization': user_token },
        contentType:false,
        processData:false,
        beforeSend: function (){

        },
        success: function(result, status, xhr) {
            $("#notifications_list").html('');
            $("#notifications_list").html(result);
            if(result != ''){
               notifiy = setInterval(function(){ 
                 $("#notify_ring").effect("shake");                                  
               }, 9000);
            }    
        }
    });
}

function under_maintenance(){
    $.ajax({
        url: baseURL +'commonrequesthandler_ui/under_maintenance',
        headers: { 'Authorization': user_token },
        contentType:false,
        cache:false,
        processData:false,
        beforeSend: function (){

        },
        success: function(result, status, xhr) {
            var res = JSON.parse(result);
            if(res.status == 'success'){
               if(res.under_maintenance > 0){
                    $("#under_maintenance").modal({backdrop: 'static', keyboard: false});
               }else{
                    session_expire();
                    check_notification();
                    $("#under_maintenance").modal('hide');
               }
            }else if(res.status == 'error'){
                swal({
                  title: "",
                  text: res.message,
                  type: "error",
                });
            }
        }
    });
}

function getTime(seconds){

    var leftover = seconds;

    var days = Math.floor(leftover / 86400);

    leftover = leftover - (days * 86400);

    var hours = Math.floor(leftover / 3600);

    leftover = leftover - (hours * 3600);

    var minutes = Math.floor(leftover / 60);

    leftover = leftover - (minutes * 60);
  
    return days + ':' + hours + ':' + minutes + ':' + leftover;
} 

function requisation_more_info(){
  under_maintenance();
	$.ajax({
       type: "POST",
       url: baseURL +"dashboard/get_requisation_details", 
       headers: { 'Authorization': user_token },
       cache:false, 
       
       beforeSend: function () {
           $(".content-wrapper").LoadingOverlay("show");
       },
       success: function(result){
          $("#requisation_toggle").html('');
          $("#requisation_toggle").html(result);
          $(".content-wrapper").LoadingOverlay("hide");
       }
    });
}


function quotation_more_info(){
    $.ajax({
      type: "POST",
      url: baseURL +"dashboard/get_quotation_details",
      headers: { 'Authorization': user_token },
      cache:false,
      beforeSend: function () {
           $(".content-wrapper").LoadingOverlay("show");
      },
      success: function(result){
          $("#requisation_toggle").html('');
          $("#requisation_toggle").html(result);
          $(".content-wrapper").LoadingOverlay("hide");
      } 
    });
}


function po_more_info(){
  $.ajax({
      type: "POST",
      url: baseURL +"dashboard/get_po_details", 
      headers: { 'Authorization': user_token },
      cache:false,
      beforeSend: function () {
        $(".content-wrapper").LoadingOverlay("show");
      }, 
      success: function(result){
          $("#requisation_toggle").html('');
          $("#requisation_toggle").html(result);
          $(".content-wrapper").LoadingOverlay("hide");
      }
  });
}