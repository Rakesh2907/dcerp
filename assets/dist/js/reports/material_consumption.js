/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 */

 $(document).ready(function(){
 		 $('.select2').select2();
 });

 function staked_bar_submit(){

     var selected_month = $("#month_list").val();
     var selected_year = $("#last_years").val();
     var selected_line_year = $("#line_last_years").val();
     var coloum_last_years = $("#coloum_last_years").val();
     var staked_last_years = $("#staked_last_years").val();
     var dep_id = $("#dep_id").val();

     $.ajax({
            type: "POST",
            url: baseURL+'reports/material_consumption',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'selected_month='+selected_month+'&selected_year='+selected_year+'&selected_line_year='+selected_line_year+'&coloum_last_years='+coloum_last_years+'&staked_last_years='+staked_last_years+'&dep_id='+dep_id+'&chart=scoloum_bar',
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show",{
                         image       : "",
                         fontawesome : "fa fa-cog fa-spin"
                });
            },
            success: function(result){
                setTimeout(function(){
                    $(".content-wrapper").html('');
                    $(".content-wrapper").html(result);     
                    $(".content-wrapper").LoadingOverlay("hide");
               }, 1500);    
            }
     });  
 }

 function column_bar_submit(){
     var selected_month = $("#month_list").val();
     var selected_year = $("#last_years").val();
     var selected_line_year = $("#line_last_years").val();
     var coloum_last_years = $("#coloum_last_years").val();
     var staked_last_years = $("#staked_last_years").val();
     var dep_id = $("#dep_id").val();

     $.ajax({
            type: "POST",
            url: baseURL+'reports/material_consumption',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'selected_month='+selected_month+'&selected_year='+selected_year+'&selected_line_year='+selected_line_year+'&coloum_last_years='+coloum_last_years+'&staked_last_years='+staked_last_years+'&dep_id='+dep_id+'&chart=scoloum_bar',
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show",{
                         image       : "",
                         fontawesome : "fa fa-cog fa-spin"
                });
            },
            success: function(result){
                setTimeout(function(){
                    $(".content-wrapper").html('');
                    $(".content-wrapper").html(result);     
                    $(".content-wrapper").LoadingOverlay("hide");
               }, 1500);    
            }
     });  
 }

 function horizontal_bar_submit(){
 	 var selected_month = $("#month_list").val();
 	 var selected_year = $("#last_years").val();
 	 var selected_line_year = $("#line_last_years").val();
     var coloum_last_years = $("#coloum_last_years").val();
     var staked_last_years = $("#staked_last_years").val();
 	 var dep_id = $("#dep_id").val();

 	 $.ajax({
            type: "POST",
            url: baseURL+'reports/material_consumption',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'selected_month='+selected_month+'&selected_year='+selected_year+'&selected_line_year='+selected_line_year+'&coloum_last_years='+coloum_last_years+'&staked_last_years='+staked_last_years+'&dep_id='+dep_id+'&chart=horizontal_bar',
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show",{
	 		  			 image       : "",
    					 fontawesome : "fa fa-cog fa-spin"
	 		    });
            },
            success: function(result){
                setTimeout(function(){
	 		        $(".content-wrapper").html('');
	 		   		$(".content-wrapper").html(result); 	
	 				$(".content-wrapper").LoadingOverlay("hide");
	 		   }, 1500);	
            }
     });
 }


function line_bar_submit(){
	 var selected_month = $("#month_list").val();
	 var selected_year = $("#last_years").val();
	 var selected_line_year = $("#line_last_years").val();
     var coloum_last_years = $("#coloum_last_years").val();
     var staked_last_years = $("#staked_last_years").val();
	 var dep_id = $("#dep_id").val();
 	 $.ajax({
            type: "POST",
            url: baseURL+'reports/material_consumption',
            headers: { 'Authorization': user_token },
            cache: false,
            data: 'selected_month='+selected_month+'&selected_year='+selected_year+'&selected_line_year='+selected_line_year+'&coloum_last_years='+coloum_last_years+'&staked_last_years='+staked_last_years+'&dep_id='+dep_id+'&chart=line',
            beforeSend: function () {
                $(".content-wrapper").LoadingOverlay("show",{
	 		  			 image       : "",
    					 fontawesome : "fa fa-cog fa-spin"
	 		    });
            },
            success: function(result){
                setTimeout(function(){
	 		        $(".content-wrapper").html('');
	 		   		$(".content-wrapper").html(result); 	
	 				$(".content-wrapper").LoadingOverlay("hide");
	 		   }, 1500);	
            }
     });
}
