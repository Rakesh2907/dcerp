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


     $("#batch_form").on('submit',function(e){ 
       e.preventDefault();
     }).validate({
         rules: {},
         messages: {},
         submitHandler: function(form) {
          var form_data = new FormData(form);
          var page_url = $(form).attr('action');

          $.ajax({
             url: baseURL +""+page_url,
             headers: { 'Authorization': user_token },
             method: "POST",
             data: form_data,
             contentType:false,
             cache:false,
             processData:false,
             beforeSend: function (){
                  $("#inward_batchwise_items").modal('hide');
             },
             success: function(result, status, xhr) {
               var res = JSON.parse(result);
               if(res.status == 'success'){
                     swal({
                        title: "",
                        text: res.message,
                        type: "success",
                        timer:2000,
                        showConfirmButton: false
                     },function(){
                        swal.close();
                        load_page(res.redirect);
                     });
               }else if(res.status == 'error'){
                    swal({
                       title: "",
                       text: res.message,
                       type: "error",
                    });
               }
             }
           });
          return false; 
         }
       });
    
       $('#batch_form #bar_code_1').rules('add', {
            required: true
       });
      
       $('#batch_form #batch_no_1').rules('add', {
            required: true
       });

       $('#batch_form #lot_no_1').rules('add', {
            required: true
       });

       $('#batch_form #batch_received_qty_1').rules('add', {
            number: true,
            required: true
       });

       $('#batch_form #accepted_qty_1').rules('add', {
            number: true,
            required: true
       });

       $('#batch_form #expire_date_1').rules('add', {
            required: true
       });

     $("#pop_up_sub_material").on('submit',function(e){ 
       e.preventDefault();
     }).validate({
         rules: {
            sub_material: {
               required : true
            }
         },
         messages: {
              sub_material: {
                  required : 'Please sub material'
              }
         },
         submitHandler: function(form) {
              var form_data = new FormData(form);
              var page_url = $(form).attr('action');

              $.ajax({
                   url: baseURL +""+page_url,
                   headers: { 'Authorization': user_token },
                   method: "POST",
                   data: form_data,
                   contentType:false,
                   cache:false,
                   processData:false,
                   beforeSend: function () {
                    
                   },
                   success: function(result, status, xhr) {
                     var res = JSON.parse(result);
                     if(res.status == 'success'){
                         swal({
                                  title: "",
                                  text: res.message,
                                  type: "success",
                                  timer:2000,
                                  showConfirmButton: false
                                              },function(){
                                                swal.close();
                                                $("#add_sub_material_form").modal('hide');
                                                 var mat_id = $("#mymat_id").val();

                                                if(mat_id > 0){
                                                      $.ajax({
                                                        type: "POST",
                                                        url: baseURL+'commonrequesthandler_ui/get_sub_materials',
                                                        headers: { 'Authorization': user_token },
                                                        cache: false,
                                                        data: JSON.stringify({mat_id:mat_id}),
                                                        beforeSend: function(){
                                                            $("#inward_batchwise_items").modal('show');
                                                        },
                                                        success: function(result){
                                                          $("#sub_material_list").html("");
                                                          $("#sub_material_list").html(result);
                                                        }
                                                      });
                                                }
                                  });
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
     })
    

});

function remove_row(row_id,mat_id,inward_id,po_id,remove_type){
    if(remove_type == 'edit')
    {
        swal({
          title: "Are you sure?",
          text: "Remove this batch or lot number?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: true,
          closeOnCancel: true 
          },function(isConfirm){
              if(isConfirm){
                              $.ajax({
                                   url: baseURL +'commonrequesthandler_ui/remove_batch_number',
                                   headers: { 'Authorization': user_token },
                                   method: "POST",
                                   data: JSON.stringify({mat_id:mat_id,inward_id:inward_id,po_id,po_id,batch_id:row_id}),
                                   contentType:false,
                                   cache:false,
                                   processData:false,
                                   beforeSend: function (){
                                       swal.close();
                                   },
                                   success: function(result, status, xhr) {
                                     var res = JSON.parse(result);
                                     if(res.status == 'success'){
                                          $("#batch_row_id_"+row_id).remove(); 
                                           swal({
                                              title: "",
                                              text: res.message,
                                              type: "success",
                                              timer:2000,
                                              showConfirmButton: false
                                           });
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
        });
    }else{
       $("#batch_row_id_"+row_id).remove();
    }
}

function remove_sub_mat_row(sub_mat_id,mat_id,inward_id,po_id,row_id,remove_type){
  if(remove_type == 'edit'){

    swal({
      title: "Are you sure?",
      text: "Remove this batch or lot number?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: true 
      },function(isConfirm){
          if(isConfirm){
                          $.ajax({
                               url: baseURL +'commonrequesthandler_ui/remove_batch_number',
                               headers: { 'Authorization': user_token },
                               method: "POST",
                               data: JSON.stringify({sub_mat_id:sub_mat_id,mat_id:mat_id,inward_id:inward_id,po_id,po_id,batch_id:row_id}),
                               contentType:false,
                               cache:false,
                               processData:false,
                               beforeSend: function (){
                                   swal.close();
                               },
                               success: function(result, status, xhr) {
                                 var res = JSON.parse(result);
                                 if(res.status == 'success'){
                                      $("#batch_row_id_"+row_id).remove(); 
                                       swal({
                                          title: "",
                                          text: res.message,
                                          type: "success",
                                          timer:2000,
                                          showConfirmButton: false
                                       });
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
    });

  }else{
      $("#batch_row_id_"+row_id).remove();
  }
  
}
  
function add_row(add_row_type){
        var row = $('#batch_list tbody tr').length;
        var new_row = row + 1;
        $.ajax({
                url: baseURL +'commonrequesthandler_ui/add_new_row',
                  headers: { 'Authorization': user_token },
                      method: "POST",
                      data: JSON.stringify({row:new_row}),
                      contentType:false,
                      cache:false,
                      processData:false,
                      beforeSend: function () {
                      },
                      success: function(result, status, xhr) {
                        $('#batch_list').append(result);
                        $('#bar_code_'+new_row).focus().select();  
                      }
        });
}
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

function set_require_date(require_date,mat_id,dep_id,table){
     $.ajax({
           type: "POST",
           url: baseURL + 'Commonrequesthandler_ui/set_require_date',
           headers: { 'Authorization': user_token },
           cache:false,
           data: 'require_date='+require_date+'&mat_id='+mat_id+'&dep_id='+dep_id+'&table='+table,
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

function add_sub_material(){
    var mat_id = $("#mymat_id").val();
    $("#pop_up_sub_material")[0].reset();
    if(mat_id > 0 || typeof mat_id !== "undefined"){
        $.ajax({
            type: "POST",
            url: baseURL+'purchase/get_material',
            headers: { 'Authorization': user_token },
            cache: false,
            data: JSON.stringify({mat_id:mat_id}),
            beforeSend: function () {
                $("#inward_batchwise_items").modal('hide');
            },
            success: function(result){
                var res = JSON.parse(result);
                if(res.status == 'success'){
                    $("#add_sub_material_form").modal('show');
                    $("#material_name").html(res.material_name);
                    $("#pop_up_sub_material #pop_up_mat_id").val(mat_id);
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
}

function open_batch_number(){
     $("#add_sub_material_form").modal('hide');
     $("#inward_batchwise_items").modal('show');
}