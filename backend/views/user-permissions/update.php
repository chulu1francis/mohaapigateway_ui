<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthPermToUser $model */

$this->title = 'Update Aauth Perm To User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aauth Perm To Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aauth-perm-to-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
