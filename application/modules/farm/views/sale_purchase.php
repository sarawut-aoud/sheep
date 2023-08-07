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
</style>
<div class="homepage">
    <div class="container-fluid pb-4 page-rlt overflow-auto ">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="row">
                
            </div>
            <div class="pt-5 pb-5">
                <div class="card-contents">
                    <?php for($i=0;$i<20;$i++) :?>
                    <div class="card-items">
                        <div class="header-content purchase">รับซื้อ</div>
                        <div class="contents-body">
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value-small">ผู้ประกาศ</div>
                                <div class="text-value-small">วันที่ 7-Aug-2023</div>
                            </div>
                            <div class="text-value">นายทดสอบ ทดสอบ</div>
                            <div class="text-value">ฟาร์มทดสอบ</div>
                        </div>
                        <div class="contents-sheep">
                            <div class="position-relative">
                                <div class="text-topic">
                                    <span>รายละเอียดแพะ</span>
                                </div>
                                <div class="line-topic"></div>
                            </div>
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value">ประเภทแพะขุน</div>
                                <div class="text-value">แพะตัวผู้ <i style="font-size:26px" class="fas fa-mars text-info"></i></div>
                            </div>
                            <div class="text-value">อายุุ 10 เดือน ถึง 12 เดือน</div>
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value">น้ำหนัก 144 กิโลกรัม</div>
                                <div class="text-value">สูง 120 เซนติเมตร</div>
                            </div>
                        </div>
                        <div class="contents-button">
                            <button type="button" class="btn btn-warning"><i class="fas fa-phone-alt"></i> ติดต่อ </button>
                            <button type="button" class="btn btn-info"><i class="fas fa-search"></i> ดูรายละเอียด </button>
                        </div>
                    </div>
                    <div class="card-items">
                        <div class="header-content sale">ขาย</div>
                        <div class="contents-body">
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value-small">ผู้ประกาศ</div>
                                <div class="text-value-small">วันที่ 7-Aug-2023</div>
                            </div>
                            <div class="text-value">นายทดสอบ ทดสอบ</div>
                            <div class="text-value">ฟาร์มทดสอบ</div>
                        </div>
                        <div class="contents-sheep">
                            <div class="position-relative">
                                <div class="text-topic">
                                    <span>รายละเอียดแพะ</span>
                                </div>
                                <div class="line-topic"></div>
                            </div>
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value">ประเภทแพะขุน</div>
                                <div class="text-value">แพะตัวผู้ <i style="font-size:26px" class="fas fa-mars text-info"></i></div>
                            </div>
                            <div class="text-value">อายุุ 10 เดือน ถึง 12 เดือน</div>
                            <div class="d-flex gap-2 align-items-center justify-content-between">
                                <div class="text-value">น้ำหนัก 144 กิโลกรัม</div>
                                <div class="text-value">สูง 120 เซนติเมตร</div>
                            </div>
                        </div>
                        <div class="contents-button">
                            <button type="button" class="btn btn-warning"><i class="fas fa-phone-alt"></i> ติดต่อ </button>
                            <button type="button" class="btn btn-info"><i class="fas fa-search"></i> ดูรายละเอียด </button>
                        </div>
                    </div>
                    <?php endfor;?>

                </div>
            </div>
        </div>
    </div>
</div>