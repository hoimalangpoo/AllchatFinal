

$(document).ready(function() {
	
	$(".chatButton").on('click', function(){
		
		var id = $(this).attr('id');
		message = $("#message"+id).val();
		console.log(message);
		if(message == "") return;
		chatwith = $('#'+id).attr('id');
		
		console.log(chatwith);
		$.post("ajax/insert_chat.php",
			{
				message: message,
				recieve: chatwith
			},
			function(data, status){
				$("#message"+id).val("");
				$("#conversation"+id).append(data);
				let chatBox = document.getElementById('conversation'+id);
				chatBox.scrollTop = chatBox.scrollHeight;
			})
	});
	
	$(".friendlist").on('click', function(){
		var id = $(this).attr('id');
		let chatBox = document.getElementById('conversation'+id);
		chatBox.scrollTop = chatBox.scrollHeight;
		let fechData = function() {
			$.post("ajax/getmsg.php", {
				id_2: id
			  },
			  function(data, status) {
				$("#conversation"+id).append(data);
				if (data != ""){
					let chatBox = document.getElementById('conversation'+id);
					chatBox.scrollTop = chatBox.scrollHeight;
				} 
			  });
		  }
		  fechData();
		  setInterval(fechData, 500);

	});
	

	let fetchD
});









