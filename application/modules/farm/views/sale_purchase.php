<style>
    .card-contents {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .card-items {
        border-radius: 1em;
        background-color: white;
        box-shadow: var(--box-shadow);
        padding: 1rem;
        position: relative;
    }

    .header-content {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: .5rem 1rem;
        border-radius: 8px;
        color: white;
        width: fit-content;
    }

    .header-content.sale {
        background-color: var(--danger-color);

    }

    .header-content.purchase {
        background-color: var(--primary-color);
    }

    .contents-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 70%;
    }

    .contents-body .text-value-small {
        font-size: 12px;
    }

    .contents-body .text-value {
        color: var(--text-black);
    }

    .contents-sheep {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    .contents-sheep .text-value {
        color: var(--text-black);
    }

    .contents-sheep .text-topic {
        justify-content: center;
        display: flex;
    }

    .contents-sheep .text-topic>span {
        text-align: center;
        font-size: 14px;
        background-color: white;
        position: relative;
        z-index: 1;
        padding-inline: 10px;
    }

    .contents-sheep .line-topic {
        border: 1px solid var(--text-small-color);
        position: absolute;
        top: 50%;
        width: 100%;
    }

    .contents-button {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
    }

    .contents {
        display: flex;
        flex-direction: column;
        gap: .5rem
    }

    .input-contents {
        display: flex;
        flex-direction: column;
        border-radius: 1em;
        box-shadow: var(--box-shadow);
        padding: 1rem;
    }

    .text-contents {
        display: flex;
        justify-content: center;
    }

    .contents-showdatable {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: var(--box-shadow);
        padding: 1rem;
        width: 100%;
    }

    .contents-showdatable-item {
        width: 100%;
    }

    .contents-showdatable-item:not(:last-child) {
        border-right: 1px solid var(--dark-small-color);
        padding: 5px;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;

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
                    <button class="btn btn-info " data-action="create" type="button" data-bs-toggle="offcanvas" data-bs-target="#createsale" aria-controls="createsale">
                        <i class="fas fa-plus-circle"></i> เพิ่มรายการซื้อ-ขาย
                    </button>
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
                    <div class="table-responsive">
                        <table id="tb-sheepsale" class="table table-striped
                    table-hover	
                    table-borderless
                    align-middle" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th style="width:20%">วัน เดือน ปี</th>
                                    <th>#</th>
                                    <th style="width:10%">รวมเงิน(บาท)</th>
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

<div class="offcanvas offcanvas-end v-offcanvas " data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="createsale" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvas-head"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <div class="mb-3">
            <label for="" class="form-label">วันที่</label>
            <input type="text" name="" id="sale-date" class="form-control datepicker" value="<?= date('d-M-Y') ?>" placeholder="">
        </div>
        <div class="contents">

        </div>
    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas" aria-label="Close">ยกเลิก</button>
        <button type="button" class="btn btn-success " id="save-sale">บันทึกข้อมูล</button>
    </div>
</div>