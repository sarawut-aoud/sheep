<style>
    
</style>
<div class="homepage">
    <div class="container pb-4 page-rlt">
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
                <h4 class="text-start">ข้อมูลฟาร์ม</h4>
                <div class="d-flex gap-2  justify-content-end">
                    <button type="button" class="btn btn-success font-m" data-action="create" data-bs-toggle="offcanvas" data-bs-target="#updatefarm" aria-controls="updatefarm">เพิ่มข้อมูลฟาร์ม</button>
                </div>
            </div>
            <div class="contents-farm-view page-rlt " id="show-content-detail-farm">

            </div>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end v-offcanvas" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="updatefarm" aria-labelledby="updatefarm">
    <div class="offcanvas-header">
        <h5 id="offcanvas-headerupdatefarm">แก้ไขข้อมูลฟาร์ม</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

    </div>
</div>