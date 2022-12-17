<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthPerm $model */

$this->title = 'Update Aauth Perm: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Aauth Perms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aauth-perm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
