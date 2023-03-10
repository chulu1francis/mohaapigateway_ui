<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Clients $model */
$this->title = 'Update Clients';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Update";
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <ol>
                    <li class="falcon-card-color text-danger">Updating the contact person details does not update the client user record.
                        <br> You will be required to update the client user record aswell</li>
                </ol>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?=
                        Html::a('<span class="fas fa-arrow-left me-1" data-fa-transform="shrink-3"></span> Back to Clients', ['clients/index'], ["class" => 'btn ' . Yii::$app->params['btnClassFalcon'] . ' btn-sm']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="../../app/email/email-detail.html">
            <?=
            $this->render('_form', [
                'model' => $model
            ])
            ?>
        </div>
    </div>
</div>
