<div class="homepage">

    <div class="container pb-4">
        <div class="row mb-3 v-card-box  p-2">
            <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
                <button type="button" class="btn btn-dark btngoback">
                    <div class="icon"><i class="fas fa-chevron-left"></i></div>
                    <div class="text-value">
                        ย้อนกลับ
                    </div>
                </button>
            </div>
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mt-2 mb-3">
                <h4 class="text-start">ข้อมูลส่วนตัว</h4>
                <div class="d-flex gap-2  justify-content-end">
                    <button data-bs-toggle="modal" data-bs-target="#updatepassword" type="button" class="btn btn-success font-m"><i class="fas fa-key"></i> แก้ไขรหัสผ่าน</button>
                    <a href="{base_url}profile/edit">
                        <button type="button" class="btn btn-warning font-m">แก้ไขข้อมูลส่วนตัว</button>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex flex-column align-items-center text-center ">
                    <div class="position-relative">
                        <img class="rounded-circle mt-5" width="150px" src="<?= $result[0]['picture'] ? base_url($result[0]['picture']) : base_url('/assets/images/blank_person.jpg') ?>">
                    </div>
                    <span class="font-weight-bold mt-3"><?= $result[0]['firstname'] ?> <?= $result[0]['lastname'] ?></span>
                    <span class="text-black-50"><?= $result[0]['email'] ?></span>
                    <span class="text-black-50">Private Profile <?= $result[0]['private_profile'] == 1 ? '<i class="fas fa-check-square text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>' ?></span>
                </div>
            </div>
            <div class="col-md-8 ">
                <div class="d-flex flex-column gap-3 mt-2 mb-3">
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="contents">
                                <div class="label">Username</div>
                                <div class="text-value"><?= $result[0]['username'] ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="contents">
                                <div class="label">ชื่อ-นามสกุล</div>
                                <div class="text-value"><?= $result[0]['firstname'] ?> <?= $result[0]['lastname'] ?></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contents">
                                <div class="label">Email</div>
                                <div class="text-value"><?= $result[0]['email'] ?></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fas fa-phone-square-alt"></i>
                            </div>
                            <div class="contents">
                                <div class="label">เบอร์โทร</div>
                                <div class="text-value"><?= $result[0]['phone'] ?></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fab fa-line"></i>
                            </div>
                            <div class="contents">
                                <div class="label">LineID</div>
                                <div class="text-value"><?= $result[0]['line'] ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="v-label w-icon">
                            <div class="icon">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <div class="contents">
                                <div class="label">Website</div>
                                <div class="text-value"><?= $result[0]['website'] ?></div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade  v-modal" id="updatepassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatepassword" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatepassword">แก้ไขรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="old_password" class="form-label">รหัสผ่านปัจจุบัน <span style="color: red;" id="alertpassword"></span></label>
                    <input type="password" class="form-control" id="old_password" placeholder="รหัสผ่านปัจจุบัน">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="" id="new_password" placeholder="รหัสผ่านใหม่">
                </div>
                <div class="mb-3">
                    <label for="new_password_check" class="form-label">ยันยืนรหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="" id="new_password_check" placeholder="ยันยืนรหัสผ่านใหม่">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="savepassword" disabled>บันทึก</button>
            </div>
        </div>
    </div>
</div>