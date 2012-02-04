var loadUrl = "command_server.php?cmd=cast";

$("#quickbrdcst").click(function(){
	var message = $('textarea#quickmsg').val();
	$('textarea#quickmsg').text('Broadcasting.  Please wait.');
	$.post(
		loadUrl,
		{msg: message},
		function(responseText){
			$("#result").html(responseText);
		},
		"html"
	);
	$('textarea#quickmsg').text('Broadcast complete');
});
