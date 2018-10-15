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
              "pageLength": 50
     });  

     $('#quotation_form').on('submit',function(e){
          e.preventDefault();
     }).validate({
          submitHandler: function(form) {
              var form_data = new FormData(form);
              var page_url = $(form).attr('action'); 
              var count_selected_supplier = $("#supplier_dropdown :selected").length;

              if(count_selected_supplier < 5)
              {
                swal({
                  title: "Are you sure?",
                  text: "Before Quotation Send. Please check again material list.",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Send Quotation",
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
                    text: "Only 4 vendors allowed to send quotation",
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
           }else{
              
           }
      }); 
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

function prepare_purchase_order(quotation_id,supplier_id,dep_id,po_type){
     
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
                  data: JSON.stringify({quo_id:quotation_id,supplier_id:supplier_id,po_type:po_type,dep_id:dep_id}),
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

function resend_quotation_request(quo_req_id){
      var supplier_id = $("#supplier_id_"+quo_req_id).val();
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