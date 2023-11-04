<style>
    .all-report-wrapper {
        display: flex;
        align-items: end;
    }

    .all-report-wrapper>div {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .all-report-wrapper .dt-buttons.btn-group {
        flex-wrap: nowrap !important;
    }
</style>
<div class="homepage">
    <div class="container-fluid pb-4 page-rlt overflow-auto ">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
            <div class=" pb-5">
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" id="show-filterbtn" class="btn btn-info"><i class="fas fa-filter"></i> ค้นหาเพิ่มเติม</button>
                </div>
                <div id="showfilter">
                    <div class="d-flex flex-column gap-2 w-100 justify-content-center mb-3">
                        <div class="d-flex flex-column flex-md-row   gap-2 justify-content-end   rounded-pill">
                            <div data-action="daynow" class="btn btn-dark btnfilter-data active">วันนี้</div>
                            <div data-action="weeknow" class="btn btn-dark btnfilter-data">สัปดาห์นี้</div>
                            <div data-action="monthnow" class="btn btn-dark btnfilter-data">เดือนนี้</div>
                            <div data-action="quarternow" class="btn btn-dark btnfilter-data">ไตรมาสนี้</div>
                            <div data-action="yearnow" class="btn btn-dark btnfilter-data">ปีนี้</div>
                            <div class="date-range-show btn btn-dark  btnfilter-data position-relative">เลือกวันที่ <i class="fas fa-caret-down"></i>
                                <input type="text" name="" id="datepicker" style="width:-webkit-fill-available;opacity: 0; position: absolute; right: 0px; z-index:-1;">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="mb-3  w-100">
                                <label for="" class="form-label">วันที่</label>
                                <input readonly type="text" name="" id="date_start" class="form-control" placeholder=""></input>
                            </div>
                            <div class="mb-3  w-100">
                                <label for="" class="form-label">ถึง</label>
                                <input readonly type="text" name="" id="date_end" class="form-control" placeholder=""></input>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-info" id="search"><i class="fas fa-search"></i> ค้นหา</button>
                        </div>
                    </div>
                </div>
                <div class="card p-3">
                    <div class="d-flex gap-2 mb-3" style="font-size: 18px;">
                        <div class="icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="text-value">กรณีต้องการดาวน์โหลดข้อมูลทั้งหมด ให้ <a role="button" class="show-all-rows text-blue">คลิกที่นี้</a> หลังจากนั้นเลือกประเภทไฟล์ส่งออก </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tb-report" class="table table-striped
                    table-hover	
                    table-borderless
                    align-middle" data-title="รายงานข้อมูลการซื้อ-ขาย" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>วัน เดือน ปี</th>
                                    <th>
                                        <div>พ่อพันธุ์</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แม่พันธุ์ </div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แพะปลด พ่อ แม่</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แพะขุน</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>มูลแพะ</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>รวมเงิน(บาท)</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                        <table id="tb-report2" class="table table-striped
                    table-hover	
                    table-borderless
                    align-middle" data-title="รายงานข้อมูลการซื้อ-ขาย" style="width: 100%;display:none">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>
                                        ชื่อ-สกุล
                                    </th>
                                    <th>วัน เดือน ปี</th>
                                    <th>
                                        <div>พ่อพันธุ์</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แม่พันธุ์ </div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แพะปลด พ่อ แม่</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>แพะขุน</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>
                                        <div>มูลแพะ</div>
                                        <div><small>จำนวน / รวม</small></div>
                                    </th>
                                    <th>รวมเงิน(บาท)</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="showpdfview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <canvas id="showpdf"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>