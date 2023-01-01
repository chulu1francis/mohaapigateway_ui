<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\OrganisationContactPersons $model */

$this->title = 'Create Organisation Contact Persons';
$this->params['breadcrumbs'][] = ['label' => 'Organisation Contact Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisation-contact-persons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
