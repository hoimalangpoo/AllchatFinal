<?php
foreach ($friends as $friend) {
?>
    <div class="content col-4 collapse " id="friendinfo<?php echo $friend['_id'] ?>">
        <div class="card">

            <div class="contact-profile card-header bg-transparent text-center align-middle" id="userSection">
                <img src="ภาพ/avatar2.png" alt="" />
                <span> <?= $friend['name'] ?> </span>

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info">ข้อมูล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#file">ไฟล์</a>
                    </li>
                </ul>

            </div>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="info">
                    <div class="card-body shadow p-4 rounded">
                        <p>ชื่อ : <?= $friend['name'] ?></p>
                        <p>เบอร์โทร : <?= $friend['telephone'] ?></p>
                        <p>อีเมล : <?= $friend['email'] ?></p>
                        <p>แผนก : <?= $friend['agency'] ?></p>

                        <a href="unfriend.php?id=<?php echo $friend["_id"] ?>">
                            <button type="button" class="btn btn-danger text-dark pull-right">ลบเพื่อน</button>
                        </a>
                    </div>
                </div>

                <div class="tab-pane fade" id="file">

                    <div class="card-body shadow p-4 rounded">
                        Boomba2
                    </div>

                </div>


            </div>
        </div>

    <?php } ?>