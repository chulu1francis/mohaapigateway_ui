<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\OrganisationContactPersons $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Organisation Contact Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organisation-contact-persons-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'organisation',
            'country',
            'title',
            'formal_title',
            'first_name',
            'last_name',
            'other_names',
            'department',
            'telephone',
            'mobile',
            'fax',
            'whatsapp_number',
            'email:email',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
