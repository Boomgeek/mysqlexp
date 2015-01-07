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
	alert("unit="+$("#unit").val()+"&article="+$("#article").val()+"&type="+$("#type").val()+"&answer="+$("#answer").val());
	$.ajax({
			url: "this/link.php",
			type: "POST",
			data: "unit="+$("#unit").val()+"&article="+$("#article").val()+"&type="+$("#type").val()+"&answer="+$("#answer").val()
	});
}

//End function zone