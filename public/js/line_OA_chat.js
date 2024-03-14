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
			$.post("/getlinetoken", {lineOAid : id}, function(data, status){
				if(status === "success"){
					let token = data['access_token'];
					console.log("Token :", token);

					$.post("/webhook", {
						message: message,
						lineOAid: chatwith,
						token: token
					}, function(data, status){
						console.log("Access Token: ", data);
					})
				}
			});
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
			console.log(id);
		

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

				$.post("/getlinetoken", {lineOAid : id}, function(data, status){
					if(status === "success"){
						let token = data['access_token'];
						console.log("Token :", token);
	
						$.post("/webhook", {
							message: message,
							lineOAid: chatwith,
							token: token
						}, function(data, status){
							console.log("Access Token: ", data);
						})
					}
				});
                
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

		let fechData = function() {
			// console.log("lineOAid =" + id + " AND " + "linech = " + lineid); 
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
		  setInterval(fechData, 2000);

	});
	

	$("#toggleButton1").click(function() {
		$(this).toggleClass("d-none"); 
		$("#inputField1").toggleClass("d-none"); 

	});

	$("#toggleButton2").click(function() {
		$(this).toggleClass("d-none"); 
		$("#inputField2").toggleClass("d-none"); 

	});

	$(".searchchat").on('click', function(){
        var rawsearchid = this.id;
		inline = rawsearchid.split("line")[1].split("boxfor")[0];
		lastchat = rawsearchid.split("line")[0].split("lastchat")[1];
		forbox = rawsearchid.split("boxforline")[1];
        console.log("ไอดี: " + rawsearchid + " แยก: " + inline + " แยกอีกที: " + lastchat + " แยกอีกีอก: " + forbox);

		var targetId = "chatuser" + lastchat + "lineOAid" + inline;

		console.log("ไอดีเป้าหมาย: " + targetId);

		

		   if ($('#' + targetId).length) {
	
			var targetOffset = $('#' + targetId).position().top;
	

			$('#conversation' + forbox).animate({
				scrollTop: targetOffset - $('#conversation' + forbox).offset().top + $('#conversation' + forbox).scrollTop()
			}, 1000);
	
			console.log("เลื่อนไปยังตำแหน่งของ " + targetId + " ภายใน #conversation' + forbox");
		} else {
			console.log("ไม่พบไอดีที่ต้องการเลื่อนไปหา");
		}

    });
	
});