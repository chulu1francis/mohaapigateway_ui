<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthUserToGroup $model */

$this->title = 'Create Aauth User To Group';
$this->params['breadcrumbs'][] = ['label' => 'Aauth User To Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aauth-user-to-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
