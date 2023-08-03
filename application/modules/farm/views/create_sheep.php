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
        top: 80px;
        z-index: 100;
        background-color: white;
        margin-top: 1rem;
    }
</style>
<div class="homepage">
    <div class="container pb-4 page-rlt">

        <div class="row">
            <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
                <button type="button" class="btn btn-dark btngoback">
                    <div class="icon"><i class="fas fa-chevron-left"></i></div>
                    <div class="text-value">
                        ย้อนกลับ
                    </div>
                </button>
            </div>
            <div class="card positon-relative">
                <div class="row-sticky">
                    <div class="row mb-3 mt-3 ">
                        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                            <button type="button" class="btn btn-success"><i class="fas fa-file-import"></i> นำเข้าข้อมูล</button>
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <button type="button" class="btn btn-warning" id="addboxContent"><i class="fas fa-plus-circle"></i> เพิ่มแถว</button>
                                <button type="button" class="btn btn-success" id="savesheep">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 " id="content-data">

                    <div class="box-content" data-index="0">
                        <div class="d-flex flex-column flex-lg-row gap-3 w-100 mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">รหัสแพะ</label>
                                <input type="text" name="" id="sheepcode_0" class="form-control sheepcode" placeholder="A001" aria-describedby="helpId">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ชื่อแพะ</label>
                                <input type="text" name="" id="sheepname_0" class="form-control sheepname" placeholder="ชื่อแพะ" aria-describedby="helpId">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ประเภทแพะ</label>
                                <select name="" id="sheeptype_0" class="form-control select2 sheeptype"></select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ฟาร์มต้นทาง</label>
                                <select name="" id="farmselect_0" class="form-control select2 farmselect"></select>
                            </div>
                        </div>

                        <div class="d-flex gap-3 w-100 mb-3">
                            <div class="form-check d-flex gap-2">
                                <input class="form-check-input gender-type" data-index="0" type="checkbox" value="1" id="male_0">
                                <label class="form-check-label" for="male_0">
                                    ตัวผู้
                                </label>
                            </div>
                            <div class="form-check d-flex gap-2">
                                <input class="form-check-input gender-type" data-index="0" type="checkbox" value="2" id="female_0">
                                <label class="form-check-label" for="female_0">
                                    ตัวเมีย
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row gap-3 w-100">
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">อายุ (เดือน)</label>
                                <input type="text" name="" id="old_0" class="form-control old" placeholder="10" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">น้ำหนัก (กก.)</label>
                                <input type="text" name="" id="weight_0" class="form-control weight" placeholder="00.00" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">ส่วนสูง (ซม.)</label>
                                <input type="text" name="" id="height_0" class="form-control height" placeholder="100" aria-describedby="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>