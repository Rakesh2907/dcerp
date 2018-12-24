function jumpon(ele){
	var pid = ele.dataset.pid;
	console.log(user_token);
	$.ajax({
        url: siteURL + "requesthandler/jump_to_project",
        headers: { 'Authorization': user_token },
        method: "POST",
        data: JSON.stringify({project_id: pid}),
        contentType: "application/json",
        dataType: "json",
        success: function (result, status, xhr) {
            console.log(result.url);
            if(result.status === "success"){
                var btn = document.getElementById("jump_to_project");
                var parent_div = btn.parentElement;
                var anchor = document.createElement("a");
                anchor.setAttribute("href",result.url);
                anchor.setAttribute("class","hidden");
                //anchor.setAttribute("target","_blank");
                parent_div.appendChild(anchor);
                anchor.click();

                parent_div.removeChild(anchor);
            }else{
                alert(result.msg);
            }
        },
        error: function (xhr, status, error) {            
            if(error !='abort'){
                alert(error);
                console.log(status);
                console.log(error);
            }
        }
    });
}