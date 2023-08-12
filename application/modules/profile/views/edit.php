<div class="container pb-4">
    <div class="row mb-3 v-card-box  p-2">
        <input type="hidden" id="pd_id" value="">
        <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
            <button type="button" class="btn btn-dark btngoback">
                <div class="icon"><i class="fas fa-chevron-left"></i></div>
                <div class="text-value">
                    ย้อนกลับ
                </div>
            </button>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
            <h4 class="text-right">แก้ไขข้อมูลส่วนตัว</h4>
        </div>
        <div class="col-md-4">
            <div class="d-flex flex-column align-items-center text-center p-3 ">
                <div class="position-relative">
                    <img id="image-main" class="rounded-circle mt-5" width="150px" src="">
                    <div class="box-camera-image">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <span class="font-weight-bold mt-3" id="fullname"></span>
                <span class="text-black-50" id="email-main"></span>
            </div>
        </div>
        <div class="col-md-8 ">
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">Username</label>
                    <input type="text" class="form-control" id="username" value="" disabled>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">ชื่อ</label>
                    <input type="text" class="form-control" id="firstname" placeholder="ชื่อ" value="">
                </div>
                <div class="col-md-6">
                    <label class="labels">นามสกุล</label>
                    <input type="text" class="form-control" id="lastname" placeholder="นามสกุล" value="">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 mb-3">
                    <label class="labels">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Email" value="">
                </div>
                <div class="col-md-12  mb-3">
                    <label class="labels">เบอร์โทร</label>
                    <input type="text" class="form-control" id="phone" placeholder="เบอร์โทร" value="" maxlength="10">
                </div>
                <div class="col-md-12  mb-3">
                    <label class="labels">LineID</label>
                    <input type="text" class="form-control" id="LineID" placeholder="LineID" value="">
                </div>
                <div class="col-md-12  mb-3">
                    <label class="labels">Website</label>
                    <input type="text" class="form-control" id="Website" placeholder="Website" value="">
                </div>

                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label class="labels">Private Profile</label>
                        <input class="form-check-input" type="checkbox" value="" id="PrivateProfile">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label class="labels">Notifications</label>
                        <input class="form-check-input" type="checkbox" value="" id="Notifications">
                    </div>
                    <label class="labels">Token Line Notification</label>
                    <input class="form-control" type="text" value="" id="tokenNotifications">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="https://notify-bot.line.me/th/" target="_blank" class="btn btn-success mt-2">คลิกที่นี่เพื่อเข้าสู่หน้าเว็บ <i class="fab fa-line"></i> Line Notify </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#showexamplelinenoti">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-between w-100">
                        <label class="labels">Receive messages</label>
                        <input class="form-check-input" type="checkbox" value="" id="Receivemessages">
                    </div>
                </div>

                <div class="mt-5 text-end mb-3">
                    <button class="btn btn-primary " id="saveprofile" type="button">บันทึกข้อมูลส่วนตัว</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<style>
    .cr-image {
        opacity: 0;
    }
</style>
<?php if ($this->agent->is_mobile()) : ?>
    <div class="offcanvas offcanvas-end w-100" tabindex="-1" id="upload-picture" aria-labelledby="upload-picture">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">อัปโหลดรูปภาพ</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="upload-demo"></div>
            <div class="d-flex w-100 justify-content-center">
                <button class="btn btn-primary btn-upload">
                    <span>อัพโหลดรูปภาพ</span>
                    <input type="file" id="upload" value="Choose a file" accept="image/*">
                </button>
            </div>

        </div>
        <div class="offcanvas-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas" aria-label="Close">ยกเลิก</button>
            <button type="button" class="btn btn-success" id="savepicture">บันทึกรูปภาพ</button>
        </div>
    </div>
<?php else : ?>
    <div class="modal fade v-modal" id="upload-picture" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upload-picture" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">อัพโหลดรูปภาพ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="upload-demo"></div>
                    <div class="d-flex w-100 justify-content-center">
                        <button class="btn btn-primary btn-upload">
                            <span>อัพโหลดรูปภาพ</span>
                            <input type="file" id="upload" value="Choose a file" accept="image/*">
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-success" id="savepicture">บันทึกรูปภาพ</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $this->load->view('modal_line') ?>