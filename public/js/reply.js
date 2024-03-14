var isSending = false;
function handleReplyButton() {
    if (isSending) {
        return;
    }

    var rawid = $(this).attr('id');
        chat_id = rawid.split("buttonreply")[1].split("chat_id")[0];
        lineid = rawid.split("chat_id")[1].split("lineid")[0];
        lineOAid = rawid.split("lineid")[1];
        message = $("#reply" + chat_id + "chat_id" + lineid + "lineid" + lineOAid).val();

    if (message == "") return;

    console.log("ข้อความ: " + message + " คุยกับ: " +chat_id + " lineid: " + lineid + "IDline: " + lineOAid);
    isSending = true;
    $.post("/reply", {
        message: message,
        chat_id: chat_id,
        reply_linech: lineid
    },
    function(data, status) {
        $("#reply" + chat_id + "chat_id" + lineid + "lineid" + lineOAid).val("");
        $("#conversation" + chat_id).append(data);
        
    if ($("#chatuser" + chat_id + "lineOAid" + lineid).hasClass('bg-warning')) {
        $("#chatuser" + chat_id + "lineOAid" + lineid).removeClass('bg-warning text-black');
        $("#chatuser" + chat_id + "lineOAid" + lineid).addClass('bg-success text-white');

        $("#chatuser" + chat_id + "lineOAid" + lineid).find('form').remove();
    } else {
        $("#chatuser" + chat_id + "lineOAid" + lineid).css("background-color", "#188754").css("color", "white");
    }

        isSending = false;
    });

        $.post("/getlinetoken", {lineOAid : id}, function(data, status){
            if(status === "success"){
                let token = data['access_token'];
                console.log("Token :", token);

                $.post("/webhook", {
                    reply: message,
                    chat_id: chat_id,
                    token: token
                }, function(data, status){
                    console.log("Access Token: ", data);
                })
            }
        });
}

function handleReplyInput(e) {
    if (e.which == 13) {
        e.preventDefault();
        if (isSending) {
            return;
        }

        var rawid = $(this).attr('id');
        chat_id = rawid.split("reply")[1].split("chat_id")[0];
        lineid = rawid.split("chat_id")[1].split("lineid")[0];
        lineOAid = rawid.split("lineid")[1];
        message = $("#reply" + chat_id + "chat_id" + lineid + "lineid" + lineOAid).val();

        if (message == "") return;

        console.log("ข้อความ: " + message + " คุยกับ: " +chat_id + " lineid: " + lineid + "IDline: " + lineOAid);
        isSending = true;
        $.post("/reply", {
                message: message,
                chat_id: chat_id,
                reply_linech: lineid
            },
            function(data, status) {
                $("#reply" + chat_id + "chat_id" + lineid + "lineid" + lineOAid).val("");
                $("#conversation" + chat_id).append(data);
                
            if ($("#chatuser" + chat_id + "lineOAid" + lineid).hasClass('bg-warning')) {
                $("#chatuser" + chat_id + "lineOAid" + lineid).removeClass('bg-warning text-black');
                $("#chatuser" + chat_id + "lineOAid" + lineid).addClass('bg-success text-white');

                $("#chatuser" + chat_id + "lineOAid" + lineid).find('form').remove();
            } else {
                $("#chatuser" + chat_id + "lineOAid" + lineid).css("background-color", "#188754").css("color", "white");
            }

                isSending = false;
            });

        
            $.post("/getlinetoken", {lineOAid : id}, function(data, status){
				if(status === "success"){
					let token = data['access_token'];
					console.log("Token :", token);

                    $.post("/webhook", {
                        reply: message,
                        chat_id: chat_id,
                        token: token
                    }, function(data, status){
						console.log("Access Token: ", data);
					})
				}
			});
           
      
    }
}
// Attach event handlers
$(".replyButton").on('click', handleReplyButton);
$("input[id^='reply']").on("keydown", handleReplyInput);