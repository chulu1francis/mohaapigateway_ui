<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\models\AauthPermToGroup;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <h5 class="fs-0 px-3 pt-3 pb-2 mb-0 "><?= $this->title ?></h5>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3" id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage groups')) {
                            echo Html::a('<span class="fas fa-edit"></span>', ['update', 'id' => $model->id],
                                    [
                                        'title' => 'Update group',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => Yii::$app->params['btnClassFalcon']
                            ]);
                            echo Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                'title' => 'Delete group',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'class' => Yii::$app->params['btnClassFalcon'],
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this user group?<br>'
                                    . 'The group will only be removed if no user is assigned to the group',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name:ntext',
                    [
                        'label' => 'Permissions',
                        'value' => function () use ($model) {
                            $rightsArray = AauthPermToGroup::getGroupPermissions($model->id);
                            return implode(", ", $rightsArray);
                        }
                    ],
                    [
                        'label' => 'Created by',
                        'attribute' => 'created_by',
                        'value' => function () use ($model) {
                            $user = !empty($model->createdBy) ? $model->createdBy->title . $model->createdBy->first_name . " " . $model->createdBy->last_name : '';
                            return $user;
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Created at',
                        'value' => function () use ($model) {
                            return date('d F, Y', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Last modified by',
                        'value' => function () use ($model) {
                            $user = !empty($model->updatedBy) ? $model->updatedBy->title . $model->updatedBy->first_name . " " . $model->updatedBy->last_name : "";
                            return $user;
                        }
                    ],
                    [
                        'label' => 'Last modified ',
                        'value' => function () use ($model) {
                            return date('d F, Y', $model->updated_at);
                        }
                    ],
                ],
            ])
            ?>
        </div>
    </div>
</div>

