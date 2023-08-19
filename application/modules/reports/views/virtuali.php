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
    <div class="row mb-3">

        <div class="card p-3">
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

        </div>
    </div>
    <hr style="height: 2px;">
    <div class="d-flex justify-content-center align-items-center g-2 bt-3 mb-3">
        <h3 id="datetext">ข้อมูลประจำวันที่ ถึงวันที่</h3>
    </div>
    <div class="row mb-3">
        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-2">
            <div class="row " id="show-countitem"></div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-2">
            <div class="card shadow  p-2 ">
                <div class="card-header">
                    <h5>จำนวนแพะทั้งหมด <span class="sheepall"></span></h5>
                </div>
                <div class="card-body">
                    <canvas id="myChart" style="position: relative; height:300px;  width:500px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-2">
            <div class="card shadow  p-2 ">
                <div class="card-header">
                    <h5>จำนวนแพะทั้งหมด <span class="sheepall"></span></h5>
                </div>
                <div class="card-body">
                    <canvas id="myChart2" style="position: relative; height:300px;  width:500px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card shadow  p-2 ">
                <div class="card-header">
                    <h5>ยอดซื้อขายแพะ-มูลแพะแยกตามประเภท</h5>
                </div>
                <div class="card-body">
                    <canvas id="myChart3" style="position: relative; height:300px;  width:500px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card shadow  p-2 ">
                <div class="card-header">
                    <h5>ยอดซื้อขายแพะ-มูลแพะทั้งหมด</h5>
                </div>
                <div class="card-body">
                    <canvas id="line-chart" style="position: relative; height:300px;  width:500px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>