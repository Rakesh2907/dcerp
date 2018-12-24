/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "index.php/user/deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".btn_unlock", function(ele){
		if(ele != undefined){
			var btn = ele.currentTarget;
			if(btn != undefined){
				var uid = btn.dataset.uid;
				if(uid !=undefined){
					jQuery.ajax({
						url : baseURL+'index.php/requesthandler/unlock_user',
				        headers: { 'Authorization': user_token },
				        method: "POST",
				        data: JSON.stringify({userId: uid}),
				        contentType: "application/json",
				        dataType: "json",
						success: function (result, status, xhr) {
							if(result.status === "success"){
				                location.reload();
				            }else{
				                alert(result.msg);
				            }
						},
						error: function (xhr, status, error) {
							console.log(xhr);
						} 
					});
				}
			}
		}
	});

	jQuery("#role").on("change", function(e){
		var frm = jQuery("#addUser")[0];
		if(frm === undefined){
			frm = jQuery("#editUser")[0];
		}
		var ele = e.target;

		if(ele.value === "4"){
			if(frm.elements.staff_type !== undefined){
				frm.elements.staff_type.disabled = false;
			}			
		}else{
			if(frm.elements.staff_type !== undefined){
				frm.elements.staff_type.disabled = true;
			}
		}

		console.log(frm);	
	});

	$("#user_list").DataTable();
});
