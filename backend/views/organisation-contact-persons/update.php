<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\OrganisationContactPersons $model */

$this->title = 'Update Organisation Contact Persons: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Organisation Contact Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organisation-contact-persons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
