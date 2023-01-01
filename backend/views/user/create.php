<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\User $model */
$this->title = 'Add user';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <h5 class="fs-0 px-3 pt-3 pb-2 mb-0 "><?= $this->title ?></h5>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?=
                        Html::a('<span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span> Back', ['index'], ["class" => 'btn btn-falcon-default btn-sm']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="../../app/email/email-detail.html">
            <div class="col-lg-12 mb3">
                <h5 class="fs-0 px-3 pt-3 pb-2 mb-0 ">Instructions</h5>
                <ol>
                    <li class="falcon-card-color fs--1">Fields marked with <span class="text-danger">*</span> are required</li>
                    <li class="falcon-card-color fs--1">Email is used for login</li>
                </ol>
            </div>  
            <?=
            $this->render('_form', [
                'model' => $model
            ])
            ?>
        </div>
    </div>
</div>
