<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
            'group',
            'first_name',
            'last_name',
            'phone',
            'email:ntext',
            'active',
            'auth_key',
            'password_hash:ntext',
            'password_reset_token',
            'verification_token:ntext',
            'ip_address:ntext',
            'login_attempts',
            'updated_by',
            'created_by',
            'created_at',
            'updated_at',
            'man_number',
            'expiry_date',
            'department',
            'username',
            'last_login',
            'lms_account_created',
        ],
    ]) ?>

</div>
