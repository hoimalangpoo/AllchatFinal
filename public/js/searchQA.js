
    $(document).ready(function() {
        $('[id^="searchqa"]').click(function() {
            var rawchatid = this.id;
            
            var chatmsgid = rawchatid.split("searchqa")[1]
            console.log(chatmsgid);
            $.ajax({
                type: 'POST',
                url: '/searchfromchat',
                data: { searchKeyword: chatmsgid },
                success: function(response) {
                    console.log(response);
                    displaySearchResults(response);
                
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });


         // ฟังก์ชันสำหรับแสดงผลลัพธ์การค้นหา
         function displaySearchResults(response) {
            var searchResultsContainer = $('#searchResults');
            searchResultsContainer.empty(); // เคลียร์ข้อมูลเก่าทิ้ง

            var searchData = JSON.parse(response);
            if (searchData.length > 0) {
                searchData.forEach(function(item) {
                    var listItem = $('<li class="list-group-item"></li>');
                    listItem.append('<b>คำถาม:</b> ' + item.question + '<br>');
                    listItem.append('<b>คำตอบ:</b> ' + item.answer + '<br>');
                    listItem.append('<a href="/delQA?id=' + item.qa_id + '"><button type="button" class="btn btn-danger btn-sm text-dark pull-right">ลบ</button></a>');
                    listItem.append('<hr>');
                    searchResultsContainer.append(listItem);
                });
            } else {
                searchResultsContainer.append('ไม่พบข้อมูลที่ตรงกับคำค้นหา');
            }
        }
    });