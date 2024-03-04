

$(document).ready(function() {
	
	$(".chatButton").on('click', function(){
		
		var id = $(this).attr('id');
		message = $("#message"+id).val();
		console.log(message);
		if(message == "") return;
		chatwith = $('#'+id).attr('id');
		
		console.log(chatwith);
		$.post("/insert_groupchat",
			{
				message: message,
				group_id: chatwith
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
			$.post("/insert_groupchat",
				{
					message: message,
					group_id: chatwith
				},
				function(data, status){
					$("#message"+id).val("");
					$("#conversation"+id).append(data);
					let chatBox = document.getElementById('conversation'+id);
					chatBox.scrollTop = chatBox.scrollHeight;
				})
        }
    });
	
	$(".grouplist").on('click', function(){
		var id = $(this).attr('id');
		let chatBox = document.getElementById('conversation'+id);
		chatBox.scrollTop = chatBox.scrollHeight;
		
		let fechData = function() {
			
			$.post("/getgroupmsg", {
				id_group: id
			  },
			  function(data, status) {
				$("#conversation"+id).append(data);
				if (data != ""){
					let chatBox = document.getElementById('conversation'+id);
					chatBox.scrollTop = chatBox.scrollHeight;
				} 
			  });
		  }
	
		  setInterval(fechData, 1000);

	});
	
	
	
	
});








