

$(document).ready(function() {
    var isSending = false;
    var isClicked = {};
	$(".replyButton").on('click', function(){
        
        if (isSending) {
            return;
        }var rawid = $(this).attr('id');
		id = rawid.split("lineOAid")[0];
		lineOA = rawid.split("lineOAid")[1];
		message = $("#reply"+id+"lineOAid"+lineOA).val();
        
        console.log(message);
        if(message == "") return;
        chatwith = $('#'+id).attr('id');
            
        console.log(chatwith);
        isSending = true;
        $.post("/reply",
                {
                    message: message,
                    chat_id: id,
                    linech:lineOA
                },
        function(data, status){
                    $("#reply"+id+"lineOAid"+lineOA).val("");
                    $("#conversation"+id).append(data);
				
                    isSending = false;
                })
        if(lineid == "1"){
				$.post("/webhookch1",
				{
					reply: message,
				    chat_id: id
				})
			}else if(lineid == "2"){
				$.post("/webhookch2",
				{
					reply: message,
				    chat_id: id
				})
			}
        
		
	});
	
    $("input[id^='reply']").on("keydown", function(e){
        if(e.which == 13){
			e.preventDefault();

            if (isSending) {
                return;
            }

            var rawid = $(this).attr('id');
            id = rawid.split("reply")[1].split("lineOAid")[0];
			lineid = rawid.split("lineOAid")[1];
			message = $("#reply"+id+"lineOAid"+lineid).val();

			console.log(message);
			if(message == "") return;
			

            isSending = true;
			$.post("/reply",
				{
					message: message,
					chat_id: id,
                    linech:lineid
				},
				function(data, status){
					$("#reply"+id+"lineOAid"+lineid).val("");
                    $("#conversation"+id).append(data);
				
                    isSending = false;
				})
             if(lineid == "1"){
				$.post("/webhookch1",
				{
					reply: message,
				    chat_id: id
				})
			}else if(lineid == "2"){
				$.post("/webhookch2",
				{
					reply: message,
				    chat_id: id
				})
			}
 
        }
    });

    $(".msglist").on('click', function(){
		var rawid = this.id;
		id = rawid.split("chatuser")[1].split("lineOAid")[0];
        lineid = rawid.split("lineOAid")[1];

       
        if (!isClicked[id]){
            isClicked[id] = true;
            $.post("/getreply", {
                chat_id: id,
                linech:lineid
              },
              function(data, status) {
                $("#conversation"+id).append(data);
                
                
              });
             
        }
              
	});

 
    

	

	
});