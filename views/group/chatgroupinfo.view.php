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
                            $role = $db->checkrole($userid, $group['group_id'], $db);
                            $headOrnot = $role[0]['role'];
                            $members = $db->getMembersByGroupId($group['group_id'], $db);
                            foreach ($members as $member) {
                                $imageUrl = base64_encode($member['profile']);
                                if ($member['role'] == "head") { ?>
                                    <li class="list-group-item groupinfo"><img class="logolineOA" src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle" /> <?= $member['name'] ?> (หัวหน้า)</li>
                                <?php  } elseif ($member['role'] == "member") { ?>

                                    <li class="list-group-item groupinfo d-flex align-items-center"><img class="logolineOA" src="data:image/png;base64,<?= $imageUrl ?>" alt="" class="rounded-circle" />
                                        <span class="flex-grow-1"><?= $member['name'] ?></span>

                                        <?php if ($headOrnot == "head") { ?>
                                            <form method="post" action="/kickmember">
                                                <input type="hidden" name="userid_kick" value="<?= $member['_id'] ?>">
                                                <input type="hidden" name="groupid_kick_user" value="<?= $group['group_id'] ?>">
                                                <button class="btn btn-danger" type="submit" onclick="return confirmDelete()">ลบออก</button>
                                            </form>
                                        <?php } ?>

                                    </li>

                                <?php } ?>



                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="tab-pane fade" id="setting<?= $group['group_id'] ?>">

                    <div class="card-body shadow p-4 rounded">
                        <button class="btn settinggroup mb-2" data-bs-toggle="modal" data-bs-target="#modalAddMember">เพิ่มสมาชิก</button><br>
                        <button class="btn settinggroup" data-bs-toggle="modal" data-bs-target="#modalRenameGroup">เปลี่ยนชื่อ</button>
                        <?php

                        if ($headOrnot == "head") { ?>
                            <form method="post" action="/deletegroup">
                                <input type="hidden" name="id_for_del" value="<?= $group['group_id'] ?>">
                                <button class="btn btn-danger deletegroup" type="submit" onclick="return confirmDelete()">ลบกลุ่ม</button>
                            </form>

                        <?php
                        }

                        ?>

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
                            <input type="hidden" name="group_id" value="<?= $group['group_id'] ?>">
                            <table style="border: 1;">
                                <thead>
                                    <tr>
                                        <th class="choose bg-warning " width="5%">เลือกเพื่อน</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $friends = $db->getFriends($userid, $group['group_id'], $db);
                                    foreach ($friends as $friend) { ?>
                                        <tr>

                                            <th class="name" style="width: 90%;">
                                                <?= $friend['name']; ?>

                                            </th>
                                            <th style="width: 10%;">
                                                <input type="checkbox" class="check pull-right" name="selected_values[]" value="<?= $friend['_id'] ?>" check="checked">
                                            </th>

                                        </tr>


                                    <?php } ?>
                                </tbody>

                            </table>
                            <button type="submit" class="btn text-dark bg-warning align-center mt-3 addmember">เพิ่มสมาชิก</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-----------------Modal RENAME GROUP---------------------------------------->

    <div class="modal fade" id="modalRenameGroup" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddLabel">เปลี่ยนชื่อกลุ่ม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3">

                        <form method="POST" action="/renamegroup">
                            <input type="hidden" name="groupid" value="<?= $group['group_id'] ?>">
                            ชื่อกลุ่ม <input type="text" name="renamegroup" class="form-control mb-3" id="FormRenameGroup" placeholder="กรอกชื่อผู้ใช้ใหม่" value="<?= $group['group_name'] ?>">
                            <button type="submit" class="btn text-dark bg-warning align-center mt-3">ยืนยัน</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>