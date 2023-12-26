<div class="col">
    <div class="card QNA">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>คำถามที่พบบ่อย</h5>
            <button class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalAddQ">เพิ่มQ&A</button>
        </div>
        <form method="post" class="d-inline-flex justify-content-center align-items-center" action="/filterQA">
            <label for="filterKeyword" class="mx-2">เลือกคำที่ต้องการคัดคำ:</label>
            <select name="filterKeyword" id="filterKeyword">
                <option value="เลือก">เลือกคำเพื่อกรอง</option>
                <option value="ที่ไหน">ที่ไหน</option>
                <option value="อย่างไร">อย่างไร</option>
                <option value="ทำไม">ทำไม</option>
                <!-- เพิ่มตัวเลือกคำต่าง ๆ ตามที่คุณต้องการ -->
            </select>

            <button type="submit" class="btn btn-primary mx-2">กรอง</button>
            <a href="/chat" class="btn btn-danger mx-2">รีเซ็ต</a>
        </form>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?php
                $filter = isset($_SESSION['filter']) ? $_SESSION['filter'] : null;
                $selectedKeyword = isset($_SESSION['selectedKeyword']) ? $_SESSION['selectedKeyword'] : null;
                unset($_SESSION['filter']);
                unset($_SESSION['selectedKeyword']);
                if (!empty($filter)) {
                    foreach ($filter as $filter_question) {
                        echo "<b>คำถาม:</b> " . $filter_question['question'] . "<br>";
                        echo "<b>คำตอบ:</b> " . $filter_question['answer'] . "<br>";
                        echo "<a href=\"/delQA?id=" . $filter_question['qa_id'] . "\"><button type=\"button\" class=\"btn btn-danger btn-sm text-dark pull-right\">ลบ</button></a>";
                        echo "<hr>";
                    }
                } else {
                    if (empty($selectedKeyword)) {
                        foreach ($announces as $announce) {
                            echo "<b>คำถาม:</b> " . $announce['question'] . "<br>";
                            echo "<b>คำตอบ:</b> " . $announce['answer'] . "<br>";
                            echo "<a href=\"/delQA?id=" . $announce['qa_id'] . "\"><button type=\"button\" class=\"btn btn-danger btn-sm text-dark pull-right\">ลบ</button></a>";
                            echo "<hr>";
                        }
                    } else {
                        echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
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