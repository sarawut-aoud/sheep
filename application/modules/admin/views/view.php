<style>
    .content-copylink {
        padding: .5rem 1rem;
        background-color: #343434;
        border-radius: 1em;
        margin: 10px;
    }

    .content-copylink .text-value {
        color: white;
        font-size: 18px;
    }

    .content-copylink.active,
    .content-copylink:active {
        box-shadow: 0px 0px 8px 1px #4bbf03;
    }
</style>
<div class="homepage">

    <div class="row">

        <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
            <button type="button" class="btn btn-dark btngoback">
                <div class="icon"><i class="fas fa-chevron-left"></i></div>
                <div class="text-value">
                    ย้อนกลับ
                </div>
            </button>
        </div>
    </div>

    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-show-content">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="   text-uppercase mb-1">
                                จำนวนผู้ใช้งานทั้งหมด
                            </div>
                            <div class="h5 mb-0  text-gray-800"><span id="countperson"></span> คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300 animeted-zoom"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 ">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <div style="width:100px">
                            <img src="{base_url}/assets/images/line/group.jpg" alt="" style="width: 100%;">
                        </div>
                        <div class="d-flex flex-column gap-3 w-100">
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <input type="text" name="" id="" value="ha2nu292YaxOnCAmoBCVWmdFcfYpk74lvfLIatyKwCO" class="form-control" placeholder="" aria-describedby="helpId" disabled>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between gap-3 align-items-center w-100">
                                <button class="btn btn-success " id="copy-link" data-link="https://line.me/ti/g/NvXpJw-Rad"><i class="fas fa-paperclip"></i> คัดลอกลิงค์เชิญเข้ากลุ่ม</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- pock create  -->
    <div class="row mb-3">
        <div class="d-flex justify-content-end">
            <button class="btn btn-info " type="button" data-bs-toggle="offcanvas" data-bs-target="#AddUser" aria-controls="offcanvasExample"><i class="fas fa-user-plus"></i> เพิ่มผู้ใช้งาน</button>
        </div>
    </div>
    <div class="row">
        <div class="card p-3">
            <div class="table-responsive">
                <table id="tbperson" class="table " style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล</th>
                            <th>จัดการให้สิทธิ์ Admin</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="offcanvas offcanvas-end v-offcanvas" tabindex="-1" id="AddUser" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">เพิ่มผู้ใช้งาน</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="input-form">
            <div class="mb-3">
                <label for="title" class="form-label">คำนำหน้า</label>
                <select class="form-control" id="title">
                    <?php foreach ($title as $key => $val) : ?>
                        <option value="<?= $val['value'] ?>"><?= $val['label'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ : <span style="color:red"> * </span></label>
                <input type="text" class="form-control" id="firstname" placeholder="ชื่อ">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">นามสกุล : <span style="color:red"> * </span></label>
                <input type="text" class="form-control" id="lastname" placeholder="นามสกุล">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">ชื่อเข้าใช้งาน : <span style="color:red"> * <span class="checkusername"></span></span></label>
                <input type="text" class="form-control" id="username" placeholder="ชื่อเข้าใช้งาน">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">อีเมลล์ : <span style="color:red"> * <span class="checkemail"></span></span></label>
                <input type="text" class="form-control" id="email" placeholder="อีเมลล์">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">รหัสเข้าใช้งาน : <span style="color:red"> * </span></label>
                <input type="password" class="form-control" id="password" placeholder="รหัสเข้าใช้งาน">
                <small class="mt-2">รหัสผ่านต้องมีตัวอักษร A-z และมากกว่า 6 หลักขึ้นไป</small>
            </div>
            <div class="mb-3">
                <label for="checkpassword" class="form-label">ยืนยันรหัสเข้าใช้งาน : <span style="color:red"> * </span></label>
                <input type="password" class="form-control" id="checkpassword" placeholder="ยืนยันรหัสเข้าใช้งาน">
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <button class="btn btn-dark" type="button" data-bs-dismiss="offcanvas" aria-label="Close">ปิด</button>
        <button class="btn btn-success" type="button" id="saveuser">บันทึก</button>
    </div>
</div>

<?php $this->load->view('modal_line') ?>