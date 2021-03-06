$(document).ready(function () {
		$('.select2').select2();

		$("#browse_material").on('click', function(){
	 	  		$("#assign_material_quotation").modal('show');
	    });	

	    var table_material = $('#material_list_pop_up').DataTable({
            'columnDefs': [{
               'targets': 0,
               'searchable':false,
               'orderable':false,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return data;
               }
            }],
            'order': [1, 'asc'],
            "pageLength": 50
       });

      var table_quaotation_request = $('#quotation_list').DataTable({
            'columnDefs': [{
               'targets': 0,
               'searchable':false,
               'orderable':false,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return data;
               }
            }],
            "pageLength": 50
       });

      $('#quotation_list tbody').on('click', '.dt-body-center', function () {
        var tr = $(this).closest('tr');
        var row = table_quaotation_request.row( tr );
        var quo_req_id = tr.attr('data-row-id');
        var supplier_id = $("#supplier_id_"+quo_req_id).val();

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            $(".details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
        }
        else {
            // Open this row
            format(quo_req_id,row,supplier_id);   
            tr.addClass('shown');
            $(".shown .details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
        }
    } );

     var table_pending_quaotation_request = $('#pending_quotation_list').DataTable({
            'columnDefs': [{
               'targets': 0,
               'searchable':false,
               'orderable':false,
               'className': 'dt-body-center',
               'render': function (data, type, full, meta){
                   return data;
               }
            }],
            "pageLength": 50
       });

      $('#pending_quotation_list tbody').on('click', '.dt-body-center', function () {
        var tr = $(this).closest('tr');
        var row = table_pending_quaotation_request.row( tr );
        var quo_req_id = tr.attr('data-row-id');
        var supplier_id = $("#supplier_id_"+quo_req_id).val();

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            $(".details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
        }
        else {
            // Open this row
            format(quo_req_id,row,supplier_id);   
            tr.addClass('shown');
            $(".shown .details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
        }
    } ); 

      var table_appr_quaotation_request = $('#approved_quotation_list').DataTable({
              'columnDefs': [{
                 'targets': 0,
                 'searchable':false,
                 'orderable':false,
                 'className': 'dt-body-center',
                 'render': function (data, type, full, meta){
                     return data;
                 }
              }],
              "pageLength": 50
         });

      $('#approved_quotation_list tbody').on('click', '.dt-body-center', function () {
            var tr = $(this).closest('tr');
            var row = table_appr_quaotation_request.row( tr );
            var quo_req_id = tr.attr('data-row-id');
            var supplier_id = $("#supplier_id_"+quo_req_id).val();

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                $(".details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_open.png');
            }
            else {
                // Open this row
                format(quo_req_id,row,supplier_id);   
                tr.addClass('shown');
                $(".shown .details-control-"+quo_req_id+" > img").attr('src', base_url_asset+'dist/img/details_close.png');
            }
      });

      $("#material_select").on('click',function(){
        var allMat = [];
         $(".sub_chk:checked").each(function() {  
                    allMat.push($(this).attr('data-id'));
         });

       var action_form = $(this).attr('data-action');
       var req_id = $(this).attr('data-quo-req');

       if(allMat.length <=0){
            swal({
              title: "",
              text: "Please select materials.",
              type: "warning",
            });
        }else{
             var join_selected_values = allMat.join(","); 

             $.ajax({
                type: "POST",  
                url: baseURL +"purchase/selected_material_quotation",
                headers: { 'Authorization': user_token },
                cache: false,
                data: 'mat_ids='+join_selected_values+'&req_id='+req_id+'&action='+action_form, 
                success: function(result, status, xhr){
                  var res = JSON.parse(result);
                  $("#assign_material_quotation").modal('hide');
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
                  }else if(res.status == 'warning'){
                      swal({
                              title: "",
                              text: res.message,
                              type: "warning",
                      });
                  }
              } 
            });
        }    
      });

      $('#selected_material_list').DataTable({
              'columnDefs': [{
                 'targets': 0,
                 'searchable':false,
                 'orderable':false,
                 'className': 'dt-body-center',
                 'render': function (data, type, full, meta){
                      return data;
                     //return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                 }
              }],
              "paging": false  
     });  

      

     $('#quotation_form').on('submit',function(e){
          e.preventDefault();
     }).validate({
          submitHandler: function(form) {
              var form_data = new FormData(form);
              var page_url = $(form).attr('action'); 
              var count_selected_supplier = $("#supplier_dropdown :selected").length;

              if(count_selected_supplier < 11)
              {
                swal({
                  title: "Are you sure?",
                  text: "Before Quotation Request Save. Please check again material list.",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Save Quotation",
                  cancelButtonText: "Ok",
                  closeOnConfirm: true,
                  closeOnCancel: true
               },function(isConfirm){
                    if(isConfirm)
                    {
                         $.ajax({
                              url: baseURL +""+page_url,
                              headers: { 'Authorization': user_token },
                              method: "POST",
                              data: form_data,
                              contentType:false,
                              cache:false,
                              processData:false,
                              beforeSend: function () {  
                                   swal.close();
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
                                  }else if(res.status == 'warning'){
                                        swal({
                                              title: "",
                                              text: res.message,
                                              type: "warning",
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
                 swal({
                    title: "",
                    text: "Only 10 vendors allowed to send quotation",
                    type: "warning",
                    cancelButtonText: "Ok",
                    closeOnCancel: true
                 });
              } 
          }
     }); 

     $('[name^="suppliers"]').each(function() {
          $(this).rules('add', {
              required: true
          })
     });

     $('[name^="require_qty"]').each(function() {
        $(this).rules('add', {
            number: true,
            required: true
        })
     });
});	

function format (quo_req_id,row,supplier_id) { 
    $.ajax({
              type: "POST",
              url: baseURL +"purchase/get_quotation_details", 
              headers: { 'Authorization': user_token },
              cache:false, 
              data: 'quo_req_id='+quo_req_id+'&supplier_id='+supplier_id,
              beforeSend: function () {
                  $(".content-wrapper").LoadingOverlay("show");
              },
              success: function(result){
                  $(".content-wrapper").LoadingOverlay("hide");
                  row.child(result).show();
              }
    });
}

function add_material(quo_req_id,action){
    swal({
                title: "Are you sure?",
                text: "Before add material. Search in material listing.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Add Material",
                cancelButtonText: "Ok",
                closeOnConfirm: true,
                closeOnCancel: true
    },function(isConfirm){
            if(isConfirm){
                $("#assign_material_quotation").modal('hide');
                load_page('purchase/add_material_form/quo_req_id/'+quo_req_id+'/'+action);
            }
    });
}

function remove_selected_material(mat_id,dep_id){
    swal({
        title: "Are you sure?",
        text: "You want to remove this records?",
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
            type: "POST",
            url: baseURL +"purchase/remove_selected_material_quotation_request", 
            headers: { 'Authorization': user_token },
            cache:false, 
            data: 'dep_id='+dep_id+'&mat_id='+mat_id,
            success: function(result){
               var res = JSON.parse(result);
               if(res.status == 'success'){
               $('table tr').filter("[data-row-id='" + mat_id + "']").remove(); 
               load_page(res.redirect);
               }
            }
          });
        }
    });
}

function get_quotation(quo_req_id,supplier_id){

    $.ajax({
       type: "POST",
       url: baseURL +"purchase/get_supplier_quotation_details", 
       headers: { 'Authorization': user_token },
       cache:false, 
       data: 'quo_req_id='+quo_req_id+'&supplier_id='+supplier_id,
       beforeSend: function () {
                     $("#supplier_quotation_details").modal('show');
       },
       success: function(result){
          $("#supplier_quotation_view").html('');
          $("#supplier_quotation_view").html(result);
       }
    });
}

function quotation_status(status,quotation_id,quo_req_id,approval_dep){
      var approve_status = status;
      var quotation_id = quotation_id;
      var quo_req_id = quo_req_id;
      var supplier_id = supplier_id;

     if(status == 'approved'){ 
          swal({
            title: "Are you sure?",
            text: "After Approved. Prepare Purchase Order.",
            type: "warning",
            showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Approved",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
          },function(isConfirm){
               if(isConfirm){

                    var checkedNum = $('input[name="material_chk[]"]:checked').length;
                    if (!checkedNum) {

                      setTimeout(function(){
                        if(approval_dep == 'Accounts'){
                                 swal({
                                          title: "",
                                          text: 'Material not approved by Purchase.',
                                          type: "warning",
                                 });
                        }else{
                               swal({
                                        title: "",
                                        text: 'Please checked Material.',
                                        type: "warning",
                               });
                        }
                      },200);
                      $("#approval_status-"+approval_dep).val('pending');
                    }else{
                        $.ajax({
                            type: "POST",
                            url: baseURL +"purchase/quotation_status",
                            headers: { 'Authorization': user_token }, 
                            cache:false,
                            data: 'status='+approve_status+'&quotation_id='+quotation_id+'&quo_req_id='+quo_req_id+'&approval_dep='+approval_dep,
                            beforeSend: function () {
                                swal.close();
                                $("#supplier_quotation_details").modal('hide');
                            },
                            success: function(result){
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
                    }    
               }else{
                   $("#approval_status-"+approval_dep).val('pending');
               }
          }); 
    }else{
       $("#approval_status-"+approval_dep).val('pending');
    }  
}

function add_vendor(quo_req_id,action){
    swal({
                title: "Are you sure?",
                text: "Before add vendor. Search in Select vendors.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Add Vendor",
                cancelButtonText: "Ok",
                closeOnConfirm: true,
                closeOnCancel: true
    },function(isConfirm){
        if(isConfirm){
            load_page('purchase/add_supplier_form/quo_req_id/'+quo_req_id+'/'+action);
        }
    });
}

function prepare_purchase_order(quotation_id,supplier_id,dep_id,po_type,cat_id){
    
    var allVals = [];  
    $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
    }); 

    if(allVals.length <=0) { 
              swal({
                                  title: "",
                                  text: 'Please checked Material.',
                                  type: "warning",
                });
    }else{
      swal({
        title: "Are you sure?",
        text: "Prepare Purchase Order.",
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
                  url: baseURL +"purchase/get_vendor_approved_quotation_details",
                  headers: { 'Authorization': user_token },
                  method: "POST",
                  data: JSON.stringify({quo_id:quotation_id,supplier_id:supplier_id,po_type:po_type,dep_id:dep_id,cat_id:cat_id}),
                  contentType:false,
                  cache:false,
                  processData:false,
                  beforeSend: function () {
                       $("#supplier_quotation_details").modal('hide');
                  },
                  success: function(result, status, xhr) {
                    var res = JSON.parse(result); 
                    if(res.status == 'success'){
                      load_page(res.redirect);
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

    } 
}

function get_vendor(dep_id){
      $.ajax({
          url: baseURL +"purchase/get_supplier_assign_department",
          headers: { 'Authorization': user_token },
          method: "POST",
          data: JSON.stringify({dep_id:dep_id}),
          contentType:false,
          cache:false,
          processData:false,
          beforeSend: function () {},
          success: function(result, status, xhr) {
               $("#supplier_dropdown").html('');
               $("#supplier_dropdown").html(result);
          }
      });
}

function resend_quotation_request(quo_req_id,supplier_id = 0){
      var supplier_id = $("#supplier_id_"+quo_req_id).val();

    swal({
                  title: "Are you sure?",
                  text: "Before Quotation Request Send to Vendor(s). Please check again material list.",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Send Quotation",
                  cancelButtonText: "Ok",
                  closeOnConfirm: true,
                  closeOnCancel: true
    },function(isConfirm){
        if(isConfirm){ 
            $.ajax({
                url: baseURL +"purchase/resend_quotation_request",
                headers: { 'Authorization': user_token },
                method: "POST",
                data: JSON.stringify({quo_req_id:quo_req_id,supplier_id:supplier_id}),
                contentType:false,
                cache:false,
                processData:false,
                beforeSend: function () {},
                success: function(result, status, xhr) {
                     
                }
            });
        }
    });      
}


function pending_resend_quotation_request(quo_req_id){
    var supplier_id = $("#pending_supplier_id_"+quo_req_id).val();
   swal({
                  title: "Are you sure?",
                  text: "Before Quotation Request Send to Vendor(s). Please check again material list.",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Send Quotation",
                  cancelButtonText: "Ok",
                  closeOnConfirm: true,
                  closeOnCancel: true
    },function(isConfirm){
        if(isConfirm){ 
              $.ajax({
                  url: baseURL +"purchase/resend_quotation_request",
                  headers: { 'Authorization': user_token },
                  method: "POST",
                  data: JSON.stringify({quo_req_id:quo_req_id,supplier_id:supplier_id}),
                  contentType:false,
                  cache:false,
                  processData:false,
                  beforeSend: function () {},
                  success: function(result, status, xhr) {
                       
                  }
              })
        }
   });   
}

function popupWindow(url){ 
    window.open(url,"MyWindow","toolbar=no, menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no,width=720,height=800");
}

function approved_quotation(quotation_id)
    {
          var allVals = [];  
          $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
          }); 

          if(allVals.length <=0) { 
              swal({
                                  title: "",
                                  text: 'Please checked material.',
                                  type: "warning",
                });
          }else{
             swal({
              title: "Are you sure?",
                text: "'APPROVED' checked Materials",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            },
             function(isConfirm) {
              if (isConfirm) 
              {
                 var join_selected_values = allVals.join(",");  
                 $.ajax({   
                      type: "POST",  
                      url: baseURL +"purchase/change_material_status",  
                      headers: { 'Authorization': user_token },
                      cache:false,  
                      data: 'ids='+join_selected_values+'&status=approval&quotation_id='+quotation_id,
                      beforeSend: function () {
                        swal.close();
                      }, 
                      success: function(result)  { 
                          var res = JSON.parse(result); 

                          setTimeout(function(){ 
                                if(res.status == 'success'){
                            swal({
                                    title: "",
                                text: res.message,
                                type: "success",
                             });
                          
                          }else if(res.status == 'error'){
                             swal({
                                    title: "",
                                text: res.message,
                                type: "error",
                             });
                         } 
                          }, 800);


                    
                      }   
                  });
              }
             }
            );
          }
    }

    function disapproved_quotation(quotation_id)
    {
      var allVals = [];  
          $(".sub_chk:unchecked").each(function() {  
                allVals.push($(this).attr('data-id'));
          }); 


          if(allVals.length <=0) { 
              swal({
                                  title: "",
                                  text: 'Please unchecked material.',
                                  type: "warning",
                });
          }else{
             swal({
              title: "Are you sure?",
                text: "'DISAPPROVED' Unchecked Materials",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            },
              function(isConfirm) {
                if(isConfirm) 
                {
                   var join_selected_values = allVals.join(",");
                   $.ajax({   
                      type: "POST",  
                      url: baseURL +"purchase/change_material_status",  
                      headers: { 'Authorization': user_token },
                      cache:false,  
                      data: 'ids='+join_selected_values+'&status=pending&quotation_id='+quotation_id,
                      beforeSend: function () {
                        swal.close();
                      }, 
                      success: function(result)  { 
                          var res = JSON.parse(result); 

                          setTimeout(function(){ 
                                if(res.status == 'success'){
                            swal({
                                    title: "",
                                text: res.message,
                                type: "success",
                             });
                          }else if(res.status == 'error'){
                             swal({
                                    title: "",
                                text: res.message,
                                type: "error",
                             });
                         } 
                          }, 800);    
                      }   
                      });
                }
                }
            );
          }
    } 

function vendor_quotations(supplier_id, quo_req_id, quotation_id = 0){

        swal({
                title: "Quotation Process",
                text: "",
                type: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Send Request to Vendor",
                cancelButtonText: "Add Quotation",
                closeOnConfirm: true,
                closeOnCancel: true,
                allowOutsideClick: true,
        },function(isConfirm) {
             if(isConfirm) {
                 $.ajax({
                    url: baseURL +"purchase/resend_quotation_request",
                    headers: { 'Authorization': user_token },
                    method: "POST",
                    data: JSON.stringify({quo_req_id:quo_req_id,supplier_id:supplier_id}),
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend: function () {},
                    success: function(result, status, xhr) {
                          var res = JSON.parse(result); 
                          if(res.status == 'success'){
                              swal({
                                      title: "",
                                  text: res.message,
                                  type: "success",
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
             }else{
                add_quotation_purchase(supplier_id,quo_req_id,quotation_id) 
             }
        });
}


 function add_quotation_purchase(supplier_id, quo_req_id, quotation_id = 0){
      $.ajax({
            url: baseURL +"purchase/quotation_request_details",
            headers: { 'Authorization': user_token },
            method: "POST",
            data: JSON.stringify({quo_req_id:quo_req_id,supplier_id:supplier_id,quotation_id:quotation_id}),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend: function () {
                $("#supplier_quotation_details").modal('hide');
            },
            success: function(result, status, xhr) { 
                   $("#add_quotation_purchase_form").modal('show');  
                   $("#quotation_materials").html('');
                   $("#quotation_materials").html(result);
            }
      });
    
 }

 function reset_val(mat_id){
       $("input[name='cgst_per["+mat_id+"]']").val(0);
       $("input[name='cgst_amt["+mat_id+"]']").val(0);
       $("input[name='sgst_per["+mat_id+"]']").val(0);
       $("input[name='sgst_amt["+mat_id+"]']").val(0);
       $("input[name='igst_per["+mat_id+"]']").val(0);
       $("input[name='igst_amt["+mat_id+"]']").val(0);
      /* $("#total_price").val(0);
       $("#total_cgst").val(0);
       $("#total_sgst").val(0);
       $("#total_igst").val(0);
       $("#other_amt").val(0);*/
}

function total_mat_amount(mat_id){
    var qty = $("input[name='quo_qty["+mat_id+"]']").val();
    var mrate = $("input[name='quo_rate["+mat_id+"]']").val();
    var mat_amount = qty * mrate;
    return mat_amount;
}

function total_amount(){
  var total_amnt = 0;
  $('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var mat_amount = $("input[name='quo_price["+mat_id+"]']").val();
          total_amnt = total_amnt + parseFloat(mat_amount);
    });
    $("#total_price").val(parseFloat(total_amnt));
}

function total_bill_amount(){
var total_bill_amt = parseFloat($("#total_price").val()) + parseFloat($("#total_cgst").val()) + parseFloat($("#total_sgst").val()) + parseFloat($("#total_igst").val()) + parseFloat($("#other_amt").val());
  
  $("#total_bill_amt").val(total_bill_amt.toFixed(2));
}


function total_cgst(){
  var total_cgst = 0;
  $('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var cgst_amt = $("input[name='cgst_amt["+mat_id+"]']").val();
          total_cgst = total_cgst + parseFloat(cgst_amt);
    });
    $("#total_cgst").val(parseFloat(total_cgst).toFixed(2));
}


function total_sgst(){
  var total_sgst = 0;
  $('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var sgst_amt = $("input[name='sgst_amt["+mat_id+"]']").val();
          total_sgst = total_sgst + parseFloat(sgst_amt);
    });

    $("#total_sgst").val(parseFloat(total_sgst).toFixed(2));
}

function total_igst(){
  var total_igst = 0;
  $('[name^="mat_id"]').each(function() {
          var mat_id = $(this).val();
          var igst_amt = $("input[name='igst_amt["+mat_id+"]']").val();
          total_igst = total_igst + parseFloat(igst_amt);
    });

    $("#total_igst").val(parseFloat(total_igst).toFixed(2));
}

function my_qty(qty,mat_id){
    var amount = total_mat_amount(mat_id);

    $("input[name='quo_price["+mat_id+"]']").val(amount);
    $("input[name='discount_per["+mat_id+"]']").val(0);
    $("input[name='discount["+mat_id+"]']").val(0);
     reset_val(mat_id);
     total_amount(); 
     total_cgst();
     total_sgst();
     total_igst();
     total_bill_amount();
}

function my_rate(rate,mat_id){
    var amount = total_mat_amount(mat_id);
    $("input[name='quo_price["+mat_id+"]']").val(amount);
    $("input[name='discount_per["+mat_id+"]']").val(0);
    $("input[name='discount["+mat_id+"]']").val(0);
    reset_val(mat_id);
    total_amount(); 
    total_cgst();
    total_sgst();
    total_igst();
    total_bill_amount();
}

function my_discount(discount_per,mat_id){
    var discount_per = $("input[name='discount_per["+mat_id+"]']").val();  

    if(discount_per.length > 1){

        swal({
              title: "",
              text: 'You are already set discount percentage.You can set Only amount/percentage',
              type: "warning",
        });

        $("input[name='discount["+mat_id+"]']").val(0); 
    }else{
        var discount_amt = $("input[name='discount["+mat_id+"]']").val(); 
        var mat_amount = total_mat_amount(mat_id);
        if(discount_amt > mat_amount){
           swal({
              title: "",
              text: 'Discount amount must be less than material total price',
              type: "warning",
           });

          $("input[name='quo_price["+mat_id+"]']").val(mat_amount);
          $("input[name='discount["+mat_id+"]']").val(0);  
        }else{
            var new_mat_amout = parseFloat(mat_amount) - parseFloat(discount_amt);
            $("input[name='quo_price["+mat_id+"]']").val(0);
            $("input[name='quo_price["+mat_id+"]']").val(parseFloat(new_mat_amout));
            reset_val(mat_id);
            total_amount(); 
            total_cgst();
            total_sgst();
            total_igst();
            total_bill_amount();
        }
    }  
}

function my_discount_per(discount_per,mat_id){
    var discount_amt = $("input[name='discount["+mat_id+"]']").val();

    if(discount_amt.length > 1){
          swal({
              title: "",
              text: 'You are already set discount amount.You can set Only Amount/Percentage',
              type: "warning",
          });
          var discount_per = $("input[name='discount_per["+mat_id+"]']").val(0);
    }else{
          var discount_per = $("input[name='discount_per["+mat_id+"]']").val();
          var mat_amount = total_mat_amount(mat_id);
          var minus_amt = ((discount_per/100) * mat_amount);

          var new_mat_amout = parseFloat(mat_amount) - parseFloat(minus_amt);
          $("input[name='quo_price["+mat_id+"]']").val(0);
          $("input[name='quo_price["+mat_id+"]']").val(parseFloat(new_mat_amout));
          reset_val(mat_id);
          total_amount();
          total_cgst();
          total_sgst();
          total_igst();
          total_bill_amount();
    }
}

function my_cgst_per(cgst_per,mat_id){
    var mat_amount = $("input[name='quo_price["+mat_id+"]']").val();

    if(mat_amount > 0){
        var cgst_amt = ((cgst_per/100) * mat_amount);
        $("input[name='cgst_amt["+mat_id+"]']").val(parseFloat(cgst_amt).toFixed(2));
        total_cgst();
        total_bill_amount();
    }else{
         swal({
              title: "",
              text: 'Material Price must be grater than 0 or 0.00',
              type: "warning",
          });
        $("input[name='cgst_per["+mat_id+"]']").val(0);
    }
}


function my_sgst_per(sgst_per,mat_id){
    var mat_amount = $("input[name='quo_price["+mat_id+"]']").val();

    if(mat_amount > 0){
      var sgst_amt = ((sgst_per/100) * mat_amount);
      $("input[name='sgst_amt["+mat_id+"]']").val(parseFloat(sgst_amt).toFixed(2));
      total_sgst();
      total_bill_amount();
    }else{
       swal({
              title: "",
              text: 'Material Price must be grater than 0 or 0.00',
              type: "warning",
       });
       $("input[name='sgst_per["+mat_id+"]']").val(0);
    }  
}

function my_igst_per(igst_per,mat_id){
    var mat_amount = $("input[name='quo_price["+mat_id+"]']").val();

    if(mat_amount > 0){
      var igst_amt = ((igst_per/100) * mat_amount);
      $("input[name='igst_amt["+mat_id+"]']").val(parseFloat(igst_amt).toFixed(2));
      total_igst();
      total_bill_amount();
    }else{
        swal({
              title: "",
              text: 'Material Price must be grater than 0 or 0.00',
              type: "warning",
       });
        $("input[name='igst_per["+mat_id+"]']").val(0);
    }  
}

function other_charges(amt){
     total_bill_amount();
}

function enabled_substitute(val, mat_id){
  if(val == 'not_available'){
      $("#substitute_material_"+mat_id).show();
  }else{
      $("#substitute_material_"+mat_id).hide();
  }
  
}