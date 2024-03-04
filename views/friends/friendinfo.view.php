<?php
foreach ($friends as $friend) {

?>
    <div class="content col collapse" id="friendinfo<?= $friend['_id'] ?>">
        <div class="card">

            <div class="contact-profile card-header bg-transparent text-center align-middle" id="userSection">

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info<?= $friend['_id'] ?>">ข้อมูล</a>
                    </li>
                   
                </ul>

            </div>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="info<?= $friend['_id'] ?>">
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

              


            </div>
        </div>
    </div>

<?php
}

?>