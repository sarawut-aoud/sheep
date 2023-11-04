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

    .d-item {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1rem;
        align-items: center;
        text-align: center;
    }

    .d-item-nodata {
        display: flex;
        width: 100%;
        gap: 1rem;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #c3c3c3;
        padding: 0.25em;
        border-radius: 0.5em;
    }

    .d-item.item-header {
        background-color: #f7f7f7;
        padding: 0.25em;
        border-radius: 1em;
        box-shadow: 2px 2px 0 0 #8b8b8b;
    }

    .d-item.item-header .item-topic {
        padding: 5px;
        font-size: 18px;
    }

    .d-list-item {
        background: #c3c3c3;
        padding: 0.25em;
        border-radius: .5em;
    }

    .d-item .list-item {
        border-radius: .5em;
        padding: 0.25em;
        background-color: #f7f7f7;
        font-size: 16px;
    }

    .d-item-badge {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 1em;
        width: 100%;
        margin-block: 1em;
    }

    .item-badge {
        width: 100%;
        display: flex;
        gap: 1em;
        padding: 1em;
        border-radius: .5em;
        background-color: #f7f7f7;
        box-shadow: 2px 2px 0 0 #8b8b8b;
        transition: all 300ms ease;
        border-left: 1.5em solid var(--info-color);
    }

    .item-badge .content {
        display: flex;
        gap: .5em;
        flex-direction: column;
        width: 100%;
        text-align: end;
    }

    .item-badge .topiccontent {
        display: flex;
        width: 100%;
        font-size: 22px;
        flex-direction: column;
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
                <div class="d-item-badge">
                    <div class="item-badge">
                        <div class="topiccontent">
                            <div><small>รวม</small></div>
                            <div> พ่อพันธุ์</div>
                        </div>
                        <div class="content">
                            <div class="text-value" id="badge-item-v1"> 0 ตัว </div>
                            <div class="label" id="badge-item-m1">0 บาท</div>
                        </div>
                    </div>
                    <div class="item-badge">
                        <div class="topiccontent">
                            <div><small>รวม</small></div>
                            <div> แม่พันธุ์</div>
                        </div>
                        <div class="content">
                            <div class="text-value" id="badge-item-v2"> 0 ตัว </div>
                            <div class="label" id="badge-item-m2">0 บาท</div>
                        </div>
                    </div>
                    <div class="item-badge">
                        <div class="topiccontent">
                            <div><small>รวม</small></div>
                            <div> แพะปลด พ่อ-แม่</div>
                        </div>
                        <div class="content">
                            <div class="text-value" id="badge-item-v3"> 0 ตัว </div>
                            <div class="label" id="badge-item-m3">0 บาท</div>
                        </div>
                    </div>
                    <div class="item-badge">
                        <div class="topiccontent">
                            <div><small>รวม</small></div>
                            <div>แพะขุน</div>
                        </div>
                        <div class="content">
                            <div class="text-value" id="badge-item-v4"> 0 ตัว </div>
                            <div class="label" id="badge-item-m4">0 บาท</div>
                        </div>
                    </div>
                    <div class="item-badge">
                        <div class="topiccontent">
                            <div><small>รวม</small></div>
                            <div>มูลแพะ</div>
                        </div>
                        <div class="content">
                            <div class="text-value" id="badge-item-v5"> 0  </div>
                            <div class="label" id="badge-item-m5">0 บาท</div>
                        </div>
                    </div>
                    <div class="item-badge">
                        <div class="topiccontent">รวมเงินทั้งหมด (บาท)</div>
                        <div class="content justify-content-center">
                            <div class="label" id="badge-item-t">0 บาท</div>
                        </div>
                    </div>
                </div>
                <div class="card p-3">
                    <!-- <div class="d-flex gap-2 mb-3" style="font-size: 18px;">
                        <div class="icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="text-value">กรณีต้องการดาวน์โหลดข้อมูลทั้งหมด ให้ <a role="button" class="show-all-rows text-blue">คลิกที่นี้</a> หลังจากนั้นเลือกประเภทไฟล์ส่งออก </div>
                    </div> -->
                    <div class="table-responsive">
                        <table id="tb-report2" class="table table-striped
                    table-hover	
                    table-borderless
                    align-middle" data-title="รายงานข้อมูลการซื้อ-ขาย" style="width: 100%;display:none">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th style="width:20%">
                                        ชื่อ-สกุล
                                    </th>
                                    <th>#</th>
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