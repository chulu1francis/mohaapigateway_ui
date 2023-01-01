<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */

$this->title = 'Create Accreditation Applications';
$this->params['breadcrumbs'][] = ['label' => 'Accreditation Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accreditation-applications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
