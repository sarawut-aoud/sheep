<style>
    .box-content {
        border-radius: 1em;
        box-shadow: var(--box-shadow);
        padding: 1rem;
        margin-bottom: .5rem;
        position: relative;
    }

    .item-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: red;
    }

    .row-sticky {
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: white;
        margin-top: 1rem;
    }

    .form-check {
        padding-left: 1.5em;
    }
</style>
<div class="homepage">
    <div class="container pb-4 page-rlt ">

        <div class="row ">
            <div class="d-flex justify-content-end justify-content-lg-between align-items-center">
                <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
                    <button type="button" class="btn btn-dark btngoback">
                        <div class="icon"><i class="fas fa-chevron-left"></i></div>
                        <div class="text-value">
                            ย้อนกลับ
                        </div>
                    </button>
                </div>
                <a class="btn btn-info " href="{base_url}farm/create_sheep">
                    <i class="fas fa-plus-circle"></i> เพิ่มข้อมูลแพะ
                </a>
            </div>

            <div class="card p-4">
                <div class="table-responsive overflow-hidden">
                    <table id="tb-viewsheep" class="table table-striped 
                    table-hover	
                    table-borderless
                    align-middle" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>รหัสแพะ</th>
                                <th>ชื่อแพะ</th>
                                <th>เพศ</th>
                                <th>อายุ</th>
                                <th>น้ำหนัก</th>
                                <th>ส่วนสูง</th>
                                <th>ประเภทแพะ</th>
                                <th>ฟาร์มต้นทาง</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="offcanvas offcanvas-end v-offcanvas" tabindex="-1" id="update_sheep" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">แก้ไขข้อมูลแพะ</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="input-form">
            <div class="mb-3">
                <label for="" class="form-label">รหัสแพะ</label>
                <input type="text" class="form-control" name="" id="sheepcode" aria-describedby="helpId" placeholder="กรอกรหัสแพะ">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">ชื่อแพะ</label>
                <input type="text" class="form-control" name="" id="sheepname" aria-describedby="helpId" placeholder="กรอกชื่อแพะ">
            </div>
            <div class="mb-3">
                <div class="d-flex gap-3 w-100 mb-3">
                    <div class="form-check d-flex gap-2">
                        <input class="form-check-input gender-type" type="checkbox" value="1" id="male_1">
                        <label class="form-check-label" for="male_1">
                            ตัวผู้
                        </label>
                    </div>
                    <div class="form-check d-flex gap-2">
                        <input class="form-check-input gender-type" type="checkbox" value="2" id="female_1">
                        <label class="form-check-label" for="female_1">
                            ตัวเมีย
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">อายุ</label>
                <input type="text" class="form-control isNumberOnly" name="" id="old" aria-describedby="helpId" placeholder="กรอกอายุ">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">น้ำหนัก</label>
                <input type="text" class="form-control isNumberOnly" name="" id="weight" aria-describedby="helpId" placeholder="กรอกน้ำหนัก">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">ส่วนสูง</label>
                <input type="text" class="form-control isNumberOnly" name="" id="height" aria-describedby="helpId" placeholder="กรอกส่วนสูง">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">ประเภทแพะ</label>
                <select type="text" class="form-control" name="" id="type-id"></select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">ฟาร์มต้นทาง</label>
                <select type="text" class="form-control" name="" id="farm-id"></select>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <button class="btn btn-dark" type="button" data-bs-dismiss="offcanvas" aria-label="Close">ปิด</button>
        <button class="btn btn-success" type="button" id="btnupdate_sheep">บันทึก</button>
    </div>
</div>