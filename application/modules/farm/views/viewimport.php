<style>
    .spreadsheet table.jexcel {
        width: 100%;
    }

    .button-save-warpper {
        justify-content: end;
        display: flex;
        background: white;
        width: 100%;
        z-index: 20;
        /* border-radius: 1em; */
        padding: 0.5rem 1rem;
    }
</style>
<div class="homepage">
    <div class="row">
        <div class="d-flex justify-content-end justify-content-lg-between align-items-center">
            <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
                <button type="button" class="btn btn-dark btngoback">
                    <div class="icon"><i class="fas fa-chevron-left"></i></div>
                    <div class="text-value">
                        ย้อนกลับ
                    </div>
                </button>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="card p-4">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-primary addrows">เพิ่มแถว</button>
                    <button type="button" class="btn btn-danger delrows">ลบแถว</button>
                </div>
                <div class="d-flex justify-content-center flex-column w-100">
                    <div id="spreadsheet" class=" spreadsheet overflow-auto" style="height: 60vh;"></div>
                    <div class="button-save-warpper">
                        <button type="button" class="btn btn-success " id="saveimport">บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>