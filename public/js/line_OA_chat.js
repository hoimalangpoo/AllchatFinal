$(document).ready(function() {
	$(".chatButton").on('click', function(){
		
		var rawid = $(this).attr('id');
		id = rawid.split("lineOAid")[0];
		lineOA = rawid.split("lineOAid")[1];
		message = $("#message"+id+"lineOAid"+lineOA).val();
		console.log(message);
		if(message == "") return;
		chatwith = $('#'+id).attr('id');
		
		console.log(lineOA);
		
		$.post("/line_oa_chat",
			{
				message: message,
				lineOAid: chatwith,
				linech:lineOA
			},
			function(data, status){
				$("#message"+id+"lineOAid"+lineid).val("");
				$("#conversation"+id).append(data);
				let chatBox = document.getElementById('conversation'+id);
				chatBox.scrollTop = chatBox.scrollHeight;
			})
		if(lineOA == "1"){
			$.post("/webhookch1",
			{
				message: message,
				lineOAid: chatwith
			})
		}else if(lineOA == "2"){
			$.post("/webhookch2",
			{
				message: message,
				lineOAid: chatwith
			})
		}	
	});

	$("input[id^='message']").on("keypress", function(e){
        if(e.which == 13){
			e.preventDefault();
            var rawid = $(this).attr('id');
			id = rawid.split("message")[1].split("lineOAid")[0];
			lineid = rawid.split("lineOAid")[1];

			message = $("#message"+id+"lineOAid"+lineid).val();
			console.log(message);
			if(message == "") return;
			chatwith = $('#'+id).attr('id');
			console.log(lineid);


			$.post("/line_oa_chat",
				{
					message: message,
					lineOAid: chatwith,
					linech:lineid
					
				},
				function(data, status){
					$("#message"+id+"lineOAid"+lineid).val("");
					$("#conversation"+id).append(data);
					let chatBox = document.getElementById('conversation'+id);
					chatBox.scrollTop = chatBox.scrollHeight;
				})
			if(lineid == "1"){
				$.post("/webhookch1",
				{
					message: message,
					lineOAid: chatwith
				})
			}else if(lineid == "2"){
				$.post("/webhookch2",
				{
					message: message,
					lineOAid: chatwith
				})
			}
                
        }
    });
	
	$(".linelist").on('click', function(){
		var rawid = this.id;
		lineid = rawid.split("lineOAid")[1];
		id = rawid.split("lineOAid")[0];
		let chatBox = $("#conversation" + id);
		let scrollToBottom = function() {
			chatBox.scrollTop(chatBox.prop("scrollHeight"));
		};
		console.log(id);
		let fechData = function() {
			$.post("/getlineOAmsg", {
				lineOAid: id,
				linech:lineid 	
			  },
			  function(data, status) {
				let beforeHeight = chatBox.prop("scrollHeight");
				$("#conversation"+id).append(data);
				let afterHeight = chatBox.prop("scrollHeight");
				
				if (afterHeight > beforeHeight) {
					chatBox.scrollTop(afterHeight);
				}
			  });
		  }
		  scrollToBottom();
		  setInterval(fechData, 1000);

	});
	

	$("#toggleButton1").click(function() {
		$(this).toggleClass("d-none"); // ซ่อนปุ่ม
		$("#inputField1").toggleClass("d-none"); // แสดงช่องกรอก

	});

	$("#toggleButton2").click(function() {
		$(this).toggleClass("d-none"); // ซ่อนปุ่ม
		$("#inputField2").toggleClass("d-none"); // แสดงช่องกรอก

	});
	
});
