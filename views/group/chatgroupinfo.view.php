<?php
foreach ($groups as $group) {

?>
    <div class="content col collapse " id="groupinfo<?= $group['group_id'] ?>">
        <div class="card">

            <div class="contact-profile card-header bg-transparent text-center align-middle" id="userSection">

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info<?= $group['group_id'] ?>">สมาชิก</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#setting<?= $group['group_id'] ?>">ตั้งค่า</a>
                    </li>
                </ul>

            </div>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="info<?= $group['group_id'] ?>">
                    <div class="card-body shadow p-4 rounded">
                        <ul class="list-group list-group-flush ">
                            <?php foreach ($members as $member) {
                                    $imageUrl = base64_encode($member['profile']);
                                if ($member['role'] == "head") { ?>
                                    <li class="list-group-item groupinfo"><img src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle" /> <?= $member['name'] ?> (หัวหน้า)</li>
                                <?php  } elseif ($member['role'] == "member") { ?>
                                    <li class="list-group-item groupinfo"><img src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle"/> <?= $member['name'] ?></li>
                                <?php } ?>



                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="tab-pane fade" id="setting<?= $group['group_id'] ?>">

                    <div class="card-body shadow p-4 rounded">
                        <p>เพิ่มสมาชิก</p>
                        <p>เปลี่ยนชื่อ</p>
                        <?php if ($group['for_line'] == 0) { ?>
                            <p>เพิ่ม lineOA</p>
                        <?php } else ?>

                    </div>

                </div>


            </div>
        </div>
    </div>
<?php } ?>