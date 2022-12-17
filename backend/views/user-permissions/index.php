<?php

use backend\models\AauthPermToUser;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use backend\models\User;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;
use backend\models\AauthPerm;

/** @var yii\web\View $this */
/** @var backend\models\AauthPermToUserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Special user permissions';
$this->params['breadcrumbs'][] = $this->title;
$fullExportMenu = "";
$read_only = true;
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <h5 class="fs-0 px-3 pt-3 pb-2 mb-0 ">Instructions</h5>
                    <ol>
                        <li class="falcon-card-color fs--1">
                            If a user was previously assigned a permission, please extend expriy for that record by searching for the permission
                        </li>
                        <li class="falcon-card-color fs--1">
                            The system will not allow assigning a user a permission which has a record already created even if its <span class="badge badge-soft-danger">revoked</span>. Delete or reactivate the existing record
                        </li>
                        <li class="falcon-card-color fs--1">
                            You can extend expiry date by clicking on the <span class="text-primary">Status</span> column and change the status to active 
                        </li>
                        <li class="falcon-card-color fs--1">
                            The system will only allow a user to have the permission for <span class="badge badge-soft-success"><?= Yii::$app->params['specialPermissionExpiry'] ?> hrs</span> only
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (backend\models\User::isUserAllowedTo('Assign permission to user')) {
                            $read_only = false;
                            echo '<button class="btn ' . Yii::$app->params['btnClass'] . ' btn-sm me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#submitInfo">
                              Assign permission
                            </button>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'user',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => User::getActiveUsersWithNames(),
                    'filterInputOptions' => ['prompt' => 'Filter by user', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        return !empty($model->user0) ? $model->user0->title . $model->user0->first_name . " " . $model->user0->last_name . "-" . $model->user0->man_number : "";
                    }
                ],
                [
                    'attribute' => 'permission',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => AauthPerm::getPerms(),
                    'filterInputOptions' => ['prompt' => 'Filter by permission', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        return !empty($model->permission0) ? $model->permission0->name : "";
                    }
                ],
                [
                    //  'class' => EditableColumn::className(),
                    'attribute' => 'active',
                    'filter' => false,
                    'readonly' => $read_only,
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'editableOptions' => [
                        'asPopover' => false,
                        'options' => ['class' => 'form-control', 'prompt' => 'Select Status...'],
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data' => [1 => 'Activate', 0 => 'Revoke'],
                    ],
                    'value' => function ($model) {
                        $str = "";
                        if (date("Y-m-d H:i:s") >= $model->expiry_date) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Revoked</span><br>";
                        } else {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Active</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                [
                    'attribute' => "expiry_date",
                    'filter' => false,
                ],
                [
                    'attribute' => "created_by",
                    'filter' => false,
                    'value' => function ($model) {
                        return !empty($model->createdBy) ? $model->createdBy->title . $model->createdBy->first_name . " " . $model->createdBy->last_name : "";
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'filter' => false,
                    'value' => function ($model) {
                        return date('d F, Y', $model->created_at);
                    }
                ],
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:100px;', 'class' => "btn-group btn-group-sm"],
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            if (User::isUserAllowedTo('Assign permission to user')) {
                                return Html::a(
                                                '<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                            'title' => 'Revoke permission',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to revoke this user permission?',
                                                'method' => 'post',
                                            ],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                    ]
                ],
            ];
            $gridColumns1 = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'user',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return !empty($model->user0) ? $model->user0->title . $model->user0->first_name . " " . $model->user0->last_name . "-" . $model->user0->man_number : "";
                    }
                ],
                [
                    'attribute' => 'permission',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return !empty($model->permission0) ? $model->permission0->name : "";
                    }
                ],
                [
                    //  'class' => EditableColumn::className(),
                    'attribute' => 'active',
                    'filter' => false,
                    'value' => function ($model) {
                        $str = "";
                        if (date("Y-m-d H:i:s") > $model->expiry_date) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Revoked</span><br>";
                        } else {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Active</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => "created_by",
                    'filter' => false,
                    'value' => function ($model) {
                        return !empty($model->createdBy) ? $model->createdBy->title . $model->createdBy->first_name . " " . $model->createdBy->last_name : "";
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'filter' => false,
                    'value' => function ($model) {
                        return date('d F, Y', $model->created_at);
                    }
                ],
            ];

            if (!empty($dataProvider) && $dataProvider->getCount() > 0) {
                $fullExportMenu = ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns1,
                            "columnSelectorMenuOptions" => [
                                'class' => 'btn btn-falcon-success',
                                'style' => 'font-size: 15px;padding-left: 10px;cursor:pointer',
                            ],
                            'columnSelectorOptions' => [
                                'label' => 'Cols...',
                                'class' => 'btn btn-falcon-default',
                            //'title' => 'Select columns to export',
                            ],
                            'batchSize' => 500,
                            'export' => [
                                'fontAwesome' => true
                            ],
                            'exportConfig' => [
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => false,
                                ExportMenu::FORMAT_PDF => false,
                                ExportMenu::FORMAT_CSV => false,
                            ],
                            'pjaxContainerId' => 'kv-pjax-container',
                            'exportContainer' => [
                                'class' => 'btn-group mr-2'
                            ],
                            'dropdownOptions' => [
                                'label' => 'Export data',
                                'class' => 'btn btn-falcon-default',
                                'title' => 'Export grid data',
                                'itemsBefore' => [
                                    '<div class="dropdown-header">Export All Data</div>',
                                ],
                            ],
                            'filename' => 'userpermissions_' . date("dmYHis")
                ]);
            }

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'resizableColumns' => true,
                'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
                // 'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                ],
                // set a label for default menu
                'export' => false,
                'exportContainer' => [
                    'class' => 'form-select js-choice'
                ],
                // your toolbar can include the additional full export menu
                'toolbar' => [
                    '{export}',
                    $fullExportMenu,
                ]
            ]);
            ?>

        </div>
    </div>
</div>
<div class="modal fade" id="submitInfo" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="submitInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1"><button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">Assign permission to user</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php
                            $_model = new AauthPermToUser();
                            $form = ActiveForm::begin(
                                            [
                                                'action' => 'create',
                                                'type' => ActiveForm::TYPE_FLOATING,
                                                'formConfig' =>
                                                [
                                                    'showRequiredIndicator' => true,
                                                ]
                            ]);
                            ?>

                            <?=
                            $form->field($_model, 'user', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'is-required',
                                    'style' => "font-size:14px;font-weight:normal;margin-bottom:-10px;",
                                ],
                            ])->widget(Select2::classname(), [
                                'data' => User::getActiveUsersWithNames(),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label("Select user");
                            ?>
                            <?=
                            $form->field($_model, 'permission', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'is-required',
                                    'style' => "font-size:14px;font-weight:normal;margin-bottom:-10px;",
                                ],
                            ])->widget(Select2::classname(), [
                                'data' => AauthPerm::getPerms(),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])->label("Select permission");
                            ?>
                            <?= Html::submitButton('Assign', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-sm font-weight-bold font-size:18px;']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex">
                                <ol>
                                    <li class="falcon-card-color fs--1">
                                        Fields marked with <span class="text-danger">*</span> are required
                                    </li>
                                    <li class="falcon-card-color fs--1">
                                        Permission will only be valid for <span class="badge badge-soft-success"><?= Yii::$app->params['specialPermissionExpiry'] ?> hrs</span> only
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
