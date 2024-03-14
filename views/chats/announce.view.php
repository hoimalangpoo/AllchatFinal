<div class="col">
    <div class="card QNA">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>คำถามที่พบบ่อย</h5>
            <button class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalAddQ">เพิ่มQ&A</button>
        </div>
        <form method="post" class="d-inline-flex justify-content-center align-items-center" action="/search">
            <label for="searchKeyword" class="mx-2">ค้นหา:</label>
            <input type="text" name="searchKeyword" id="searchKeyword">

            <button type="submit" class="btn mx-2 searchqabutton">ค้นหา</button>
            <a href="/chat" class="btn mx-2 searchqabutton">ทั้งหมด</a>
        </form>

        <ul class="list-group list-group-flush">
            <li id="searchResults" class="list-group-item">
                <?php
                $qasearch = isset($_SESSION['search']) ? $_SESSION['search'] : null;
                $Keyword = isset($_SESSION['Keyword']) ? $_SESSION['Keyword'] : null;
                unset($_SESSION['search']);
                unset($_SESSION['Keyword']);
                if (!empty($qasearch)) {
                    foreach ($qasearch as $search_question) {
                        echo "<b>คำถาม:</b> " . $search_question['question'] . "<br>";
                        echo "<b>คำตอบ:</b> " . $search_question['answer'] . "<br>";
                        echo "<a href=\"/delQA?id=" . $search_question['qa_id'] . "\"><button type=\"button\" class=\"btn btn-danger btn-sm text-dark pull-right\">ลบ</button></a>";
                        echo "<hr>";
                    }
                } elseif (!empty($Keyword)) {
                    echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
                } else {
                    foreach ($announces as $announce) {
                        echo "<b>คำถาม:</b> " . $announce['question'] . "<br>";
                        echo "<b>คำตอบ:</b> " . $announce['answer'] . "<br>";
                        echo "<a href=\"/delQA?id=" . $announce['qa_id'] . "\"><button type=\"button\" class=\"btn btn-danger btn-sm text-dark pull-right\">ลบ</button></a>";
                        echo "<hr>";
                    }
                }
                ?>
            </li>
        </ul>
    </div>
</div>

<!-----------------Modal Add Q&A---------------------------------------->

<div class="modal fade" id="modalAddQ" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">เพิ่มQ&A</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 mt-3">
                    <form method="POST" action="/addQA">
                        <div class="form-group">
                            <textarea type="text" name="question" class="auto-resize form-control mb-2 form-control" id="exampleFormControlTextarea1" placeholder="คำถาม"></textarea>
                            <textarea type="text" name="answer" class="auto-resize form-control mb-2 form-control" id="exampleFormControlTextarea1" placeholder="คำตอบ"></textarea>
                            <button type="submit" name="search" class="auto-resize btn btn-warning text-dark" value="เพิ่ม">เพิ่ม</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var multipleFields = document.querySelectorAll('.auto-resize');
    for (var i = 0; i < multipleFields.length; i++) {
        multipleFields[i].addEventListener('input', autoResizeHeight, 0);
    }

    function autoResizeHeight() {
        this.style.height = "auto";
        this.style.height = this.scrollHeight + "px";
        this.style.borderColor = "green";
    }
</script>