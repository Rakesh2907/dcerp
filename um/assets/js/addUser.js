/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	var addUserForm = $("#addUser");
	
	var validator = addUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "index.php/user/checkEmailExists", type :"post"} },
			login_user_name :{ required : true, remote : { url : baseURL + "index.php/user/checkUserNameExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			projects : { required : true, selected : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required" },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			login_user_name :{ required : "This field is required", remote : "User name already taken." },
			password : { required : "This field is required" },
			cpassword : {required : "This field is required", equalTo: "Please enter same password" },
			projects : { required : "This field is required", selected : "Please select atleast one option" },
			role : { required : "This field is required", selected : "Please select atleast one option" }			
		}
	});
});
