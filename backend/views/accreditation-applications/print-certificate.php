<?php

use yii\helpers\Html;
?>

<div class="container ">
    <div class="row">
        <div class="text-left">
            <?= Html::img('@web/img/AU_logo_main.png', ['style' => 'width:100px; height: 100px']); ?>
        </div>
        <div style="margin-top: -100px;" class="text-right">
            <?= Html::img('@web/img/logo.png', ['style' => 'width:100px; height: 100px']); ?>
        </div>
    </div>
    <div class="text-center" style="margin-top: 20px;margin-bottom: 100px;margin-top: -100px;font-weight: bold;">
        <p>
            AFRICAN UNION<br>
            ACCREDITATION CERTIFICATE
        </p>
    </div>
    <p style="font-weight: bold;font-size: 16px;">Accreditation number:<?= $model->number ?></p>
    <p style="font-weight: bold;margin-bottom: 3px;">This is to certify that CSO <?=$model->organisation0->name?></p>
    <p style="font-weight: bold;margin-bottom: 3px;">Has been accredited <?=$model->type?> status by ECOSOCC for African Union</p>
 
</div>


