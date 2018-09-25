/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
 
$(document).ready(function () {

	 $("#mycollapse").on('click',function(){
          $(".box-body").hide();
          $('#mycollapse2').show();
          $('#mycollapse').hide();
     });
     $("#mycollapse2").on('click',function(){
          $(".box-body").show();
          $('#mycollapse').show();
          $('#mycollapse2').hide();
     });
     $("#myclose").on('click',function(e){
     	 $("#modal-default").modal('hide');
     });

});

function update_units(unit_id,mat_id,table_name){
          $.ajax({
               type: "POST",
               url: baseURL +"Commonrequesthandler_ui/update_units", 
               headers: { 'Authorization': user_token },
               cache:false, 
               data: 'unit_id='+unit_id+'&mat_id='+mat_id+'&table='+table_name,
               beforeSend: function () {
                       $(".content-wrapper").LoadingOverlay("show");
               },
               success: function(result){
                  $(".content-wrapper").LoadingOverlay("hide");
               }
          });
}

function set_quantity(quantity,mat_id,table){
  if($.isNumeric(quantity) && quantity.length > 0)
  {  
      $.ajax({
              type: "POST",
              url: baseURL +"Commonrequesthandler_ui/set_quantity", 
              headers: { 'Authorization': user_token },
              cache:false, 
              data: 'qty='+quantity+'&mat_id='+mat_id+'&table='+table,
              beforeSend: function () {
                    $(".content-wrapper").LoadingOverlay("show");
              },
              success: function(result){
                   var res = JSON.parse(result);
                   if(res.status == 'success'){
                      $(".content-wrapper").LoadingOverlay("hide");
                   }
                   $(".content-wrapper").LoadingOverlay("hide");  
              }
      });
   } 
}

function set_require_date(require_date,mat_id,table){
     $.ajax({
           type: "POST",
           url: baseURL + 'Commonrequesthandler_ui/set_require_date',
           headers: { 'Authorization': user_token },
           cache:false,
           data: 'require_date='+require_date+'&mat_id='+mat_id+'&table='+table,
           beforeSend: function () {
                    $(".content-wrapper").LoadingOverlay("show");
           },
           success: function(result){
                   var res = JSON.parse(result);
                   if(res.status == 'success'){
                      $(".content-wrapper").LoadingOverlay("hide");
                   }
                   $(".content-wrapper").LoadingOverlay("hide");  
          }
     });
}