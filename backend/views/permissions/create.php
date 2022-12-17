<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthPerm $model */

$this->title = 'Create Aauth Perm';
$this->params['breadcrumbs'][] = ['label' => 'Aauth Perms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aauth-perm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
