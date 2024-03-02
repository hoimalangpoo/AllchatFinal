function translate(sentences, from_lang = 'th', to_lang = 'en') {
    sentences = sentences.replace(/\n/g, '<br>');
    let endPoint = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${from_lang}&tl=${to_lang}&dt=t&ie=UTF-8&oe=UTF-8&q=${encodeURIComponent(sentences)}`;

    // ใช้ Fetch API แทน XMLHttpRequest
    fetch(endPoint)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok, status: ${response.status}`);
            }
            return response.json();
        })
        .then(jsonText => {
            
            var text = jsonText[0][0][0];
            text = text.replace(/<br>/g, '\n');
       
            sendTextToPHP(text);
        })
        .catch(error => {
            console.error('Error during fetch operation:', error);
        });
}

function sendTextToPHP(text) {
    console.log("Received from PHP:", text);
    fetch("/translatemessage", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded", // ลองเปลี่ยนเป็น application/json
        },
        body: "text=" + encodeURIComponent(text),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Network response was not ok, status: ${response.status}`);
        }
        return response.text();
    })
    .then(data => {
        console.log(data); // แสดงผลลัพธ์ที่ได้จาก PHP
    })
    .catch(error => {
        console.error("Error:", error);
    });
}


function submit_thai2en() {
    var message_tran = document.getElementById('translate_msg').value;
    console.log("thToen: " + message_tran);
    translate(message_tran);
}

function submit_en2thai() {
    var message_tran = document.getElementById('translate_msg').value;
    console.log("enToth: " + message_tran);
    translate(message_tran, 'en', 'th');
}
