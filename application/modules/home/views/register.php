<style>
    .font-float {
        font-weight: 400 !important;
    }
</style>
<section class="pb-3 overflow-auto vh-100" style="background-color: #508bfc;">
    <div class="container mt-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="mt-3 col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-4 ">
                        <div class="d-flex justify-content-start mb-3">
                            <button type="button" class="btn btn-dark btngoback">
                                <div class="icon"><i class="fas fa-chevron-left"></i></div>
                                <div class="text-value">
                                    ย้อนกลับ
                                </div>
                            </button>
                        </div>
                        <div class="mb-5 d-flex justify-content-center align-items-center gap-3 w-100 page-rlt ">
                            <div style="width: 85px;">
                                <img src="{base_url}/assets/images/icon.png" class="w-100 box-image rounded-circle">
                            </div>
                            <div>
                                <h3>สมัครสมาชิก</h3>
                            </div>
                        </div>
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

                        <button class="btn btn-primary btn-block mb-4" type="button" id="btnregister">สมัครมาชิก</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>