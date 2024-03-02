<div class="ltext align-self-start border rounded p-2 collapse mb-2" id="collapse<?php echo $chat['chat_id'] ?>" aria-labelledby="heading<?php echo $chat['chat_id'] ?>" data-parent="#chatuser<?php echo $chat['chat_id'] ?>lineOAid<?= $chat['recieve_id'] ?>">
    <div id="conversation<?php echo $chat['chat_id'] ?>">

    </div>
    <div class="message-input" id="replySection">
        <div class="message-input" id="replyContainer" style="display: block">
            <div class="wrap" style="display: flex">
                <input type="text" class="chatMessage" id="reply<?php echo $chat['chat_id'] ?>lineOAid<?= $chat['recieve_id'] ?>" placeholder="ตอบกลับ..." />

                <button class="replyButton" id="<?php echo $chat['chat_id'] ?>lineOAid<?= $line['id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

            </div> <br>
            <div class="wrap2">
            <textarea id="input_area" name="message" rows="2"  >แปลภาษาข้อความ</textarea>
            <button onclick="submit_thai2en()">แปลภาษา</button> 
            <textarea id="translated_area" name="message" rows="2" ></textarea>
            
            

            </div>
        </div>
    </div>
    <script>

                function translate(sentences, targetDiv, from_lang ='th', to_lang='en'){
                    /*if (language == 'english') {
                        endPoint = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=ar&tl=en&dt=t&ie=UTF-8&oe=UTF-8&q="
                    } */
                
                sentences = sentences.replace(/\n/g, '<br>')
                let endPoint = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${from_lang}&tl=${to_lang}&dt=t&ie=UTF-8&oe=UTF-8&q=${encodeURIComponent(sentences)}` ;
                                        
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var jsonText = JSON.parse(this.responseText);
                        text = jsonText[0][0][0]
                        text = text.replace(/<br>/g, '\n')
                    targetDiv.innerHTML = "&nbsp;" + text;	  
                    }
                };
                xhttp.open("GET", endPoint, true);
                xhttp.send();
                }

                function submit_thai2en(){		
                    translate(input_area.value, translated_area)
                }

                function submit_en2thai(){		
                    translate(input_area.value, translated_area, from_lang ='en', to_lang='th')
                }
            </script>
</div>


