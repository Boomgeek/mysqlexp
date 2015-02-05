$(document).ready(function(){					//wait for load DOM
//Start Event Listener zone
	$("#submit").click(function() {
		sendPractice();
	});

//End Event Listener zone
});

//Start function zone
function sendPractice()
{
	//alert("mode=answer&unit="+$("#unit").val()+"&article="+$("#article").val()+"&type="+$("#type").val()+"&answer="+$("#answer").val());
	$.ajax({
			url: "../mysqlreport/service.php",
			type: "POST",
			data: "mode=answer&unit="+$("#unit").val()+"&article="+$("#article").val()+"&type="+$("#type").val()+"&answer="+$("#answer").val(),
			success:function(result)
			{
				alert(result);
			}
	});
}

//End function zone