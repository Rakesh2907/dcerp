/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

$(document).ready(function () {
  var table_unit = $('#unit_list').DataTable({
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
            'order': [1, 'asc'],
            'pageLength': 50
  });

  $('#unit_list-select-all').on('click', function(){
        var rows = table_unit.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });

  $('#unit_list tbody').on('change', 'input[type="checkbox"]', function(){
        if(!this.checked){
           var el = $('#unit_list-select-all').get(0);
           if(el && el.checked && ('indeterminate' in el)){
              el.indeterminate = true;
           }
        }
   });

  
    $('#delete_all_unit').on('click', function(e) { 
        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
          allVals.push($(this).attr('data-id'));
        });  
        //alert(allVals.length); return false;  
        if(allVals.length <=0)  {  
           swal({
                                  title: "",
                                  text: 'Please select row.',
                                  type: "warning",
            });
        }  
        else {  

          swal({
              title: "Are you sure?",
              text: "You want to delete this records?",
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
                url: baseURL +"purchase/delete_units",  
                cache:false,  
                data: 'ids='+join_selected_values,  
                success: function(response)  { 
                  swal.close();
                  var res = JSON.parse(response);
                  if(response=='false'){
                       alert("This unit not possible to delete. It's used");
                  }else{
                      //$('table tr').filter("[data-row-id='" + unit_id + "']").remove();
                      //load_page('purchase/unit');
                  }  
                }   
              });
            }
          });
        }  
     });

     $('#export_unit').on('click', function(e){
        var allVals = [];
          $(".sub_chk:checked").each(function(){
            allVals.push($(this).attr('data-id'))
          });

          if(allVals.length <=0){
            swal({
                                  title: "",
                                  text: 'Please select row.',
                                  type: "warning",
            });
          }else{
            var join_selected_values = allVals.join(","); 
            $.ajax({
              type: "REQUEST",
              url: baseURL +"purchase/export_units",
              cache: false,
              data: 'ids='+join_selected_values,
              beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show",{
                   image       : "",
                   fontawesome : "fa fa-cog fa-spin"
                });
              },
              success: function(){
                setTimeout(function(){
                  $(".content-wrapper").LoadingOverlay("hide");
                  window.open(baseURL +'purchase/export_units/?ids='+join_selected_values,'_blank' );
                   }, 5000);    
              }
            });
          }
     });
});


function edit_unit(unit_id){
  if(unit_id > 0){
    $.ajax({
       url: baseURL + "purchase/get_unit",
       headers: { 'Authorization': user_token },
           method: "POST",
           data: JSON.stringify({unit_id: unit_id}),
           contentType:false,
             cache:false,
             processData:false,
           success: function (result, status, xhr) {
                        result = JSON.parse(result);
                        $("#unit_id").val(result[0]['unit_id']);
                        $("#unit").val(result[0]['unit']);
                        $("#unit_description").val(result[0]['unit_description']);
                    $('#modal-default').modal('show');
           },
           error: function (xhr, status, error) {}
    });
  }else{
     alert('error: edit unit');
  } 
}

function remove_unit(unit_id) {

  swal({
  title: "Are you sure?",
  text: "You want to delete this record?",
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
     $.ajax({   
      type: "POST",  
      url: baseURL +"purchase/delete_units",  
      cache:false,  
      data: 'ids='+unit_id,  
      success: function(response){ 
            swal.close();
            var res = JSON.parse(response);

            if(res.status == 'success'){
                 $('table tr').filter("[data-row-id='" + unit_id + "']").remove();
                  setTimeout(function(){
                         swal({
                                title: "",
                                text: res.message,
                                type: "success",
                          },function(){
                              load_page(res.redirect);
                          });
                  }, 300);
            }else if(res.status == 'warning'){
                setTimeout(function(){
                      swal({
                              title: "",
                              text: res.message,
                              type: "warning",
                      });
                }, 300);
            }else if(res.status == 'error'){
                setTimeout(function(){
                      swal({
                            title: "",
                            text: res.message,
                            type: "error",
                      });
                }, 300);
            }
       }   
    });
  }
});

}