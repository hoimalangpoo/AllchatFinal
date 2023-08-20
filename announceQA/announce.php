<div class="col">
    <div class="card QNA">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>คำถามที่พบบ่อย</h5>
            <button class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalAddQ">เพิ่มQ&A</button>
        </div>
        <ul class="list-group list-group-flush ">
            <li class="list-group-item ">
                <?php
                $friend = $conn->prepare("SELECT * FROM announceqa");
                $friend->execute();
                if ($friend->rowCount() > 0) {
                    foreach ($friend as $result) { ?>
                        <b>คำถาม:</b> <?= $result[1] ?> <br>
                        <b>คำตอบ:</b> <?= $result[2] ?>
                    <?php  }
                } else { ?>
                    &nbsp;
                <?php
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
                    <form method="POST" action="back/AddQNA.php">
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