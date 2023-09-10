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
                    <div class="card-body p-5 text-center">

                        <div class="mb-5 d-flex justify-content-center w-100 align-items-center  gap-3">
                            <div style="width: 85px;">
                                <img src="{base_url}/assets/images/sheep.png" class="w-100">
                            </div>
                            <div>
                                <h3>เข้าสู่ระบบ</h3>
                                <span>แอปพลิเคชันบริหารจัดการข้อมูลแพะคอกกลาง</span>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputUser" placeholder="name@example.com" autocomplete="off">
                            <label class="font-float" for="inputUser">Email or Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off">
                            <label class="font-float" for="inputPassword">Password</label>
                        </div>

                        <div class="d-flex justify-content-end mb-4">
                            <!-- Simple link -->
                            <a href="{base_url}home/forgetpassword">ลืมรหัสผ่าน ?</a>
                        </div>

                        <button class="btn btn-primary  btn-block mb-4" id="btnlogin" type="button">เข้าสู่ระบบ</button>
                        <div class="text-center">
                            <p>ยังไม่ได้ลงทะเบียน ? <a href="{base_url}home/register">ลงทะเบียน</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>