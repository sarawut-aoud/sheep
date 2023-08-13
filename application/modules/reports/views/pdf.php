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
$img = FCPATH .  './assets/images/sheep.png';

?>
<style>
    * {
        font-size: 16px;
    }

    #paper {
        width: 21cm;
        padding-left: 1.5cm;
        padding-right: 1.5cm;
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
</style>
<div id="paper">
    <div class="w-100 text-center">
        <img alt="Image " style="width:100px" src="<?= $img ?>">
    </div>
</div>