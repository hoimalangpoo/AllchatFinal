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
                            <?php 
                            $members = $db->getMembersByGroupId($group['group_id'],$db);
                            foreach ($members as $member) {
                                $imageUrl = base64_encode($member['profile']);
                                if ($member['role'] == "head") { ?>
                                    <li class="list-group-item groupinfo"><img src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle" /> <?= $member['name'] ?> (หัวหน้า)</li>
                                <?php  } elseif ($member['role'] == "member") { ?>
                                    <li class="list-group-item groupinfo"><img src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle" /> <?= $member['name'] ?></li>
                                <?php } ?>



                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="tab-pane fade" id="setting<?= $group['group_id'] ?>">

                    <div class="card-body shadow p-4 rounded">
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#modalAddMember">เพิ่มสมาชิก</button>
                        <p>เปลี่ยนชื่อ</p>
                        <?php if ($group['for_line'] == 0) { ?>
                            <p>เพิ่ม lineOA</p>
                        <?php } else ?>

                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-----------------Modal Add Member---------------------------------------->

    <div class="modal fade" id="modalAddMember" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">เพิ่มสมาชิก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">

                        <form method="POST" action="/addmember">
                            <input type="hidden" name="groupid" value="<?= $group['group_id'] ?>">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="choose bg-warning " width="5%">เลือกเพื่อน</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($friends as $friend) { ?>
                                        <tr>

                                            <th class="name" style="width: 90%;">
                                                <?php echo $friend['name']; ?>

                                            </th>
                                            <th style="width: 10%;">
                                                <input type="checkbox" class="check pull-right" name="selected_values[]" value="<?= $friend['_id'] ?>" check="checked">
                                            </th>

                                        </tr>


                                    <?php } ?>
                                </tbody>

                            </table>
                            <button type="submit" class="btn text-dark bg-warning align-center mb-5">เพิ่มสมาชิก</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>