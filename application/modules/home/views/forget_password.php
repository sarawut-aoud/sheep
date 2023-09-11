<style>
    .font-float {
        font-weight: 400 !important;
    }
</style>
<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
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
                        <div class="mb-5 d-flex justify-content-center align-items-center w-100 gap-3">
                            <div style="width: 85px;">
                                <img src="{base_url}/assets/images/icon.png" class="w-100">
                            </div>
                            <div>
                                <h3>ขอรหัสผ่านใหม่</h3>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-center mb-3">
                                <p class="">คุณลืมรหัสผ่านใช่หรือไม่ ? กรอก E-mail เพื่อรับรหัสผ่านใหม่ </p>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">อีเมลล์</label>
                                <input type="text" class="form-control" id="email" placeholder="อีเมลล์">
                            </div>
                        </div>
                        <button class="btn btn-primary  btn-block mb-4" id="sendemail" disabled type="button">ขอรหัสผ่านใหม่</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>