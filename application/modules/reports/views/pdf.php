<?php

function nbsp($param)
{
    for ($i = 1; $i <= $param; $i++) {
        echo '&nbsp;';
    }
}
function dot($param)
{
    for ($i = 1; $i <= $param; $i++) {
        echo '.';
    }
}


?>
<style>
    * {
        font-size: 16px;
    }

    #paper {
        padding-left: 1cm;
        padding-right: 1cm;
        padding-bottom: 0cm;
        position: relative;

    }

    .w-100 {
        width: 100% !important;
    }

    .w-50 {
        width: 50% !important;
    }

    .right {
        float: right;
        width: 50%;
    }

    .left {
        float: left;
        width: 50%;
    }

    .f-right {
        float: right;
        width: 50%;
    }

    .f-left {
        float: left;
        width: 50%;
        margin-top: 1rem;

    }

    .text-center {
        text-align: center !important;
    }

    .text-start {
        text-align: left !important;
    }

    .text-end {
        text-align: right !important;
    }

    .underline {
        border-bottom: 1px;
        border-style: dashed;
        border-color: #6c757d;
    }

    .tab {
        margin-left: 0.9cm;
    }

    .boldderr {
        font-weight: bold;
    }

    .b {
        border: 1px solid #000
    }
    .item-data{
        padding: .5rem 1rem;
    }
</style>
<div id="paper" class="w-100 text-center ">
    <!-- cellpadding="0" cellspacing="0" -->
    <table class="w-100" autosize="1" style="page-break-inside:avoid" border="0" cellspacing="0">
        <thead>
            <tr style="text-align:center;width:100%;">
                <th class="b" colspan="20" style="width:100%;">บัญชีการซื้อขายแพะ - มูลแพะปี <?= Datethai(date('Y-m-d'), 'Y') ?></th>
            </tr>
            <tr>
                <th class="b" rowspan="2">วัน / เดือน /ปี</th>
                <th class="b" rowspan="2">ชื่อ - สกุล</th>
                <th class="b" colspan="3">พ่อพันธุ์</th>
                <th class="b" colspan="3">แม่พันธุ์</th>
                <th class="b" colspan="4">แพะปลด พ่อ แม่</th>
                <th class="b" colspan="4">แพะขุน</th>
                <th class="b" colspan="3">มูลแพะ</th>
                <th class="b" rowspan="2">รวมเงิน</th>
            </tr>
            <tr>
                <th class="b">จำนวน</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
                <th class="b">จำนวน</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
                <th class="b">จำนวน</th>
                <th class="b">กิโลกรัม</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
                <th class="b">จำนวน</th>
                <th class="b">กิโลกรัม</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
                <th class="b">จำนวน</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
            </tr>
            <tr>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
            </tr>
            <tr>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
                <td class="b item-data"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="b text-center" colspan="2">รวมยอด</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
                <td class="b text-end">0</td>
            </tr>
        </tfoot>
    </table>
</div>