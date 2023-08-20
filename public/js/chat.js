

$(document).ready(function() {
	
	$(".chatButton").on('click', function(){
		
		var id = $(this).attr('id');
		message = $("#message"+id).val();
		console.log(message);
		if(message == "") return;
		chatwith = $('#'+id).attr('id');
		
		console.log(chatwith);
		$.post("/insert_chat",
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

	$(document).on("keypress", "input", function(e){
        if(e.which == 13){
            
            var rawid = $(this).attr('id');
			id = rawid.split("message")[1];
			message = $("#message"+id).val();
			console.log(message);
			if(message == "") return;
			chatwith = $('#'+id).attr('id');
		
			console.log(chatwith);
			$.post("/insert_chat",
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
        }
    });
	
	$(".friendlist").on('click', function(){
		var id = $(this).attr('id');
		let chatBox = document.getElementById('conversation'+id);
		chatBox.scrollTop = chatBox.scrollHeight;
		let fechData = function() {
			$.post("/getmsg", {
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
	

	
});









