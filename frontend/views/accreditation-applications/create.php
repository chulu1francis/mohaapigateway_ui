<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */

$this->title = 'Consultative';
$this->params['breadcrumbs'][] = ['label' => 'My Consultative applications', 'url' => ['consultative']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card mb-3">
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
