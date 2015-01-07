$(document).ready(function(){					//wait for load DOM

//Start effect loding zone
	$(document).ajaxStart(function() {			//start ajax
      $("body").addClass("loading");    
  	});
	$(document).ajaxStop(function() {			//stop ajax
      $("body").removeClass("loading");    
  	});
//End effect loding zone

//Start Event Listener zone
	checkdb();									//check frist login for create database

	$('#restoredb').click(function(){
		restoredb();
	});

	$('#submitcode').click(function(){
		sendcode();
		sendlog();
	});

//End Event Listener zone
});

//Start function zone
function sendcode()
{
	$.ajax({
			url:"./source/php/controller.php",
			type: "POST",
			data: "mode=sendcode&code="+$('#textareaCode').val(),
			success:function(result)
			{
				//alert(result);
				var split;
				split  = result.split(":");
				if(split[0] == "Success")
				{
					var data;
					data = "<div class='alert alert-success alert-dismissible'>";
					data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      				data += "<strong>"+split[0]+":</strong>"+split[1]+"</div>";
					$("#status").html(data);
					$("#result").html(null);
				}
				else if(split[0] == "Error")
				{
					var data;
					data = "<div class='alert alert-danger alert-dismissible'>";
					data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      				data += "<strong>"+split[0]+":</strong>"+split[1]+"</div>";
					$("#status").html(data);
					$("#result").html(null);
				}
				else
				{
					$("#status").html(null);
					$("#result").html(result);
				}
    		}
    	});
}

function sendlog()
{
	alert("code="+$('#textareaCode').val()+"&unit="+$('#unit').val()+"&article="+$('#article').val()+"&type="+$('#type').val());
	$.ajax({
			url:"./source/php/test_log.php",
			type: "POST",
			data: "code="+$('#textareaCode').val()+"&unit="+$('#unit').val()+"&article="+$('#article').val()+"&type="+$('#type').val()
    	});
}

function restoredb()
{
	if(confirm("Do you want restore database ?"))
		$.ajax({
			url:"./source/php/controller.php",
			type: "POST",
			data: "mode=restoredb",
			success:function(result)
			{
				$("#result").html(null);
				if(result == "ok"){
					var data;
					data = "<div class='alert alert-success alert-dismissible'>";
					data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      				data += "<strong>Restore database successful.</strong> You can query <kbd>show databases;</kbd> for checking database.</div>";
      				$("#status").html(data);
				}else{
					var data;
					data = "<div class='alert alert-danger alert-dismissible'>";
					data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      				data += "<strong>Can't restore database.</strong></div>";
      				$("#status").html(data);
				}
    		}
    	});
}

function checkdb()
{
	$.ajax({
		url:"./source/php/controller.php",
		type: "POST",
		data: "mode=checkdb",
		success:function(result)
		{
			if(result == "ok"){
				var data;
				data = "<div class='alert alert-success alert-dismissible'>";
				data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      			data += "<strong>Create new database successful.</strong> You can query <kbd>show databases;</kbd> for checking database.</div>";
      			$("#status").html(data);
			}else{
				var data;
				data = "<div class='alert alert-info alert-dismissible'>";
				data += "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>";
      			data += "<strong>Have database already.</strong> You can query <kbd>show databases;</kbd> for checking database.</div>";
      			$("#status").html(data);
			}
    	}
    });
}

//End function zone