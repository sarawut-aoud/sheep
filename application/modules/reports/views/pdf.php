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

    .item-data {
        padding: .3rem;
        text-align: right;
    }

    .item-sum {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
    }
</style>
<?php

?>
<div id="paper" class="w-100 text-center ">
    <!-- cellpadding="0" cellspacing="0" -->
    <table class="w-100" autosize="1" style="page-break-inside:avoid" border="0" cellspacing="0">
        <thead>
            <tr style="text-align:center;width:100%;">
                <th class="b" colspan="25" style="font-size:20px;width:100%;">บัญชีการซื้อขายแพะ - มูลแพะประระหว่างวันที่ <?= Datethai($datestart, '') ?>-<?= Datethai($dateend, '') ?></th>
            </tr>
            <tr>
                <th class="b" rowspan="2">วัน / เดือน /ปี</th>
                <th class="b" rowspan="2">ชื่อ - สกุล</th>
                <th class="b" colspan="4">พ่อพันธุ์</th>
                <th class="b" colspan="4">แม่พันธุ์</th>
                <th class="b" colspan="4">แพะปลด พ่อ แม่</th>
                <th class="b" colspan="4">แพะขุน</th>
                <th class="b" colspan="3">มูลแพะ</th>
                <th class="b" rowspan="2">รวมเงิน</th>
            </tr>
            <tr>
                <th class="b">จำนวน</th>
                <th class="b">กิโลกรัม</th>
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
                <th class="b">กิโลกรัม</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
              
                <th class="b">จำนวน</th>
                <th class="b">ราคา</th>
                <th class="b">รวม</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $val) :
                $sumprice[] = $val->pricetotal;
                $sum0[] = $val->rowdata[0]->amount;
                $sum1[] = $val->rowdata[1]->amount;
                $sum2[] = $val->rowdata[2]->amount;
                $sum3[] = $val->rowdata[3]->amount;
                $sum4[] = $val->rowdata[4]->amount;

                $weight0[] = $val->rowdata[0]->weight;
                $weight1[] = $val->rowdata[1]->weight;
                $weight2[] = $val->rowdata[2]->weight;
                $weight3[] = $val->rowdata[3]->weight;
                $weight4[] = $val->rowdata[4]->weight;

                $price0[] = $val->rowdata[0]->price;
                $price1[] = $val->rowdata[1]->price;
                $price2[] = $val->rowdata[2]->price;
                $price3[] = $val->rowdata[3]->price;
                $price4[] = $val->rowdata[4]->price;



                $total0[] = $val->rowdata[0]->totlal;
                $total1[] = $val->rowdata[1]->totlal;
                $total2[] = $val->rowdata[2]->totlal;
                $total3[] = $val->rowdata[3]->totlal;
                $total4[] = $val->rowdata[4]->totlal;
            ?>
                <tr>
                    <td class="b item-data"><?= Datethai($val->saledate, '', true) ?></td>
                    <td class="b item-data"><?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') ?></td>

                    <td class="b item-data"><?= $val->rowdata[0]->amount > 0 ? $val->rowdata[0]->amount : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[0]->weight > 0 ? number_format($val->rowdata[0]->weight, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[0]->price > 0 ? number_format($val->rowdata[0]->price, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[0]->totlal > 0 ? number_format($val->rowdata[0]->totlal, 2) : "" ?></td>

                    <td class="b item-data"><?= $val->rowdata[1]->amount > 0 ? $val->rowdata[1]->amount : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[1]->weight > 0 ? number_format($val->rowdata[1]->weight, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[1]->price > 0 ? number_format($val->rowdata[1]->price, 2) : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[1]->totlal > 0 ? number_format($val->rowdata[1]->totlal, 2) : '' ?></td>

                    <td class="b item-data"><?= $val->rowdata[2]->amount > 0 ? $val->rowdata[2]->amount : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[2]->weight > 0 ? number_format($val->rowdata[2]->weight, 2) : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[2]->price > 0 ? number_format($val->rowdata[2]->price, 2)  : '' ?></td>
                    <td class="b item-data"><?= $val->rowdata[2]->totlal > 0 ? number_format($val->rowdata[2]->totlal, 2) : '' ?></td>

                    <td class="b item-data"><?= $val->rowdata[3]->amount > 0 ? $val->rowdata[3]->amount : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[3]->weight > 0 ? number_format($val->rowdata[3]->weight, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[3]->price > 0 ? number_format($val->rowdata[3]->price, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[3]->totlal > 0 ? number_format($val->rowdata[3]->totlal, 2) : "" ?></td>

                    <td class="b item-data"><?= $val->rowdata[4]->amount > 0 ? $val->rowdata[4]->amount : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[4]->price > 0 ? number_format($val->rowdata[4]->price, 2) : "" ?></td>
                    <td class="b item-data"><?= $val->rowdata[4]->totlal > 0 ? number_format($val->rowdata[4]->totlal, 2) : "" ?></td>

                    <td class="b item-data text-center"><?= $val->pricetotal ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="b item-sum" colspan="2">รวมยอด</td>

                <td class="b item-sum"><?= array_sum($sum0) ?></td>
                <td class="b item-sum"><?= number_format(array_sum($weight0), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($price0), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($total0), 2)  ?></td>

                <td class="b item-sum"><?= array_sum($sum1) ?></td>
                <td class="b item-sum"><?= number_format(array_sum($weight1), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($price1), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($total1), 2)  ?></td>

                <td class="b item-sum"><?= array_sum($sum2) ?></td>
                <td class="b item-sum"><?= number_format(array_sum($weight2), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($price2), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($total2), 2)  ?></td>

                <td class="b item-sum"><?= array_sum($sum3) ?></td>
                <td class="b item-sum"><?= number_format(array_sum($weight3), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($price3), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($total3), 2)  ?></td>

                <td class="b item-sum"><?= array_sum($sum4) ?></td>
                <td class="b item-sum"><?= number_format(array_sum($price4), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($total4), 2)  ?></td>
                <td class="b item-sum"><?= number_format(array_sum($sumprice), 2)  ?></td>
            </tr>
        </tfoot>
    </table>
</div>