<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthUserToGroup $model */

$this->title = 'Update Aauth User To Group: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aauth User To Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aauth-user-to-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
