var isSending = false;

function handleReplyButton() {
    if (isSending) {
        return;
    }

    var rawid = $(this).attr('id');
    chat_id = rawid.split("chat_id")[0];
    lineid = rawid.split("chat_id")[1];
    message = $("#reply" + chat_id + "chat_id" + lineid).val();

    console.log(message);
    if (message == "") return;
    chatwith = $('#' + chat_id).attr('id');

    console.log(chatwith);
    isSending = true;
    $.post("/reply", {
            message: message,
            chat_id: chat_id,
            reply_linech: lineid
        },
        function(data, status) {
            $("#reply" + chat_id + "chat_id" + lineid).val("");
            $("#conversation" + chat_id).append(data);

            isSending = false;
        });

    if (lineid == "1") {
        $.post("/webhookch1", {
            reply: message,
            chat_id: chat_id
        })
    } else if (lineid == "2") {
        $.post("/webhookch2", {
            reply: message,
            chat_id: chat_id
        })
    }
}

function handleReplyInput(e) {
    if (e.which == 13) {
        e.preventDefault();

        if (isSending) {
            return;
        }

        var rawid = $(this).attr('id');
        chat_id = rawid.split("reply")[1].split("chat_id")[0];
        lineid = rawid.split("chat_id")[1];
        message = $("#reply" + chat_id + "chat_id" + lineid).val();

        if (message == "") return;

        isSending = true;
        $.post("/reply", {
                message: message,
                chat_id: chat_id,
                reply_linech: lineid
            },
            function(data, status) {
                $("#reply" + chat_id + "chat_id" + lineid).val("");
                $("#conversation" + chat_id).append(data);

                isSending = false;
            });

        if (lineid == "1") {
            $.post("/webhookch1", {
                reply: message,
                chat_id: chat_id
            })
        } else if (lineid == "2") {
            $.post("/webhookch2", {
                reply: message,
                chat_id: chat_id
            })
        }
    }
}

// Attach event handlers
$(".replyButton").on('click', handleReplyButton);
$("input[id^='reply']").on("keydown", handleReplyInput);