<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แปลภาษา</title>
</head>
<body>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>แปลภาษา</h5>
            </div>
            <textarea id="translate_msg" rows="5">ลองทำการแปลภาษา</textarea>
            <br>
            <br>
            <button onclick="submit_thai2en()">แปลภาษาจากไทยเป็นอังกฤษ</button>
            <br>
            <button onclick="submit_en2thai()">แปลภาษาจากอังกฤษเป็นไทย</button>
            <br>
            <br>
            <div id="translated_text"></div>
        </div>
    </div>

    <script>
        function translate(sentences, targetDiv, from_lang = 'th', to_lang = 'en') {
            sentences = sentences.replace(/\n/g, '<br>')
            let endPoint = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${from_lang}&tl=${to_lang}&dt=t&ie=UTF-8&oe=UTF-8&q=${encodeURIComponent(sentences)}`;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var jsonText = JSON.parse(this.responseText);
                    text = jsonText[0][0][0]
                    text = text.replace(/<br>/g, '\n')
                    targetDiv.innerHTML = "&nbsp;" + text;
                    console.log("แปล: " + text)
                }
            };
            xhttp.open("GET", endPoint, true);
            xhttp.send();
        }

        function submit_thai2en() {
            var message_tran = document.getElementById('translate_msg').value;
            console.log("thToen: " + message_tran);
            translate(message_tran, translated_text);
        }

        function submit_en2thai() {
            var message_tran = document.getElementById('translate_msg').value;
            console.log("enToth: " + message_tran);
            translate(message_tran, translated_text, 'en', 'th');
        }
    </script>
</body>
</html>
