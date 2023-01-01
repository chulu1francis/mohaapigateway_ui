<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */

$this->title = 'Update Accreditation Applications: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accreditation Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accreditation-applications-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
