<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AauthPermToUser $model */

$this->title = 'Create Aauth Perm To User';
$this->params['breadcrumbs'][] = ['label' => 'Aauth Perm To Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aauth-perm-to-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
