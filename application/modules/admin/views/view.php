<style>
    .content-copylink {
        padding: .5rem 1rem;
        background-color: #343434;
        border-radius: 1em;
        margin: 10px;
    }

    .content-copylink .text-value {
        color: white;
        font-size: 18px;
    }

    .content-copylink.active,
    .content-copylink:active {
        box-shadow: 0px 0px 8px 1px #4bbf03;
    }
</style>
<div class="homepage">

    <div class="row">
        <div class="d-flex justify-content-start mt-3 mb-3 button-goback ">
            <button type="button" class="btn btn-dark btngoback">
                <div class="icon"><i class="fas fa-chevron-left"></i></div>
                <div class="text-value">
                    ย้อนกลับ
                </div>
            </button>
        </div>
    </div>
    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 card-show-content">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="   text-uppercase mb-1">
                                จำนวนผู้ใช้งานทั้งหมด
                            </div>
                            <div class="h5 mb-0  text-gray-800"><span id="countperson"></span> คน</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300 animeted-zoom"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 ">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <div style="width:100px">
                            <img src="{base_url}/assets/images/line/group.jpg" alt="" style="width: 100%;">
                        </div>
                        <div class="d-flex flex-column gap-3 w-100">
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <input type="text" name="" id="" value="ha2nu292YaxOnCAmoBCVWmdFcfYpk74lvfLIatyKwCO" class="form-control" placeholder="" aria-describedby="helpId" disabled>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between gap-3 align-items-center w-100">
                                <button class="btn btn-success " id="copy-link" data-link="https://line.me/ti/g/NvXpJw-Rad"><i class="fas fa-paperclip"></i> คัดลอกลิงค์เชิญเข้ากลุ่ม</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card p-3">
            <div class="table-responsive">
                <table id="tbperson" class="table " style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล</th>
                            <th>จัดการให้สิทธิ์ Admin</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('modal_line') ?>