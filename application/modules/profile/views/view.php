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
        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
            <h4 class="text-right">ข้อมูลส่วนตัว</h4>
            <div>
                <a href="{base_url}profile/edit">
                    <button type="button" class="btn btn-warning">แก้ไขข้อมูลส่วนตัว</button>
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
                <span class="text-black-50">Private Profile <i class="fas fa-check-square text-success"></i></span>
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
                            <div class="text-value"></div>
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
                            <div class="text-value"></div>
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
                            <div class="text-value"></div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>