<?php

use backend\models\Clients;
use backend\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use backend\models\AauthPermToGroup;
use kartik\export\ExportMenu;
use backend\models\AauthGroups;
use backend\models\Departments;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;

/** @var yii\web\View $this */
/** @var backend\models\ClientsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
$read_only = true;
$fullExportMenu = "";
?>

<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">


                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage clients')) {
                            $read_only = false;
                            echo Html::a('<span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Add client', ['create'],
                                    [
                                        'class' => Yii::$app->params['btnClassFalcon'] . ' me-1 mb-1',
                                        'title' => 'Add new client',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                            ]);
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
                // 'id',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => Clients::getClientsByName(),
                    'filterInputOptions' => ['prompt' => 'Filter by client', 'class' => 'form-control', 'id' => null],
                ],
                [
                    'attribute' => 'username',
                    'label' => 'Code',
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'contact_person_first_name',
                    'format' => 'raw',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->contact_person_first_name . " " . $model->contact_person_last_name;
                    }
                ],
                [
                    'attribute' => 'phone',
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'filter' => false,
                ],
                // 'address',
                //'username',
                //'secret_key',
                [
                    'attribute' => 'can_pay',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => ['Yes' => 'Yes', 'No' => 'No'],
                    'filterInputOptions' => ['prompt' => 'Filter', 'class' => 'form-control', 'id' => null],
                ],
                [
                    'class' => EditableColumn::className(),
                    'attribute' => 'active',
                    'filter' => false,
                    'readonly' => $read_only,
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [1 => 'Active', 0 => 'Inactive'],
                    'filterInputOptions' => ['prompt' => 'Filter by Status', 'class' => 'form-control', 'id' => null],
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'editableOptions' => [
                        'asPopover' => false,
                        'options' => ['class' => 'form-control', 'prompt' => 'Select Status'],
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data' => [1 => 'Active', 0 => 'Deactivate'],
                    ],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->active == 1) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Active</span><br>";
                        }
                        if ($model->active == 0) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Inactive</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                //'created_at',
                //'updated_at',
                //'created_by',
                //'updated_by',
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:80px;', 'class' => "btn-group btn-group-sm"],
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(
                                    '<span class="fas fa-eye"></span>', ['view', 'id' => $model->id], [
                                'title' => 'View',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'data-pjax' => '0',
                                'style' => "padding:5px;",
                                'class' => 'col-auto btn-group btn-group-sm ' . Yii::$app->params['btnClassFalcon'],
                                    ]
                            );
                        },
                        'update' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage clients')) {
                                return Html::a(
                                                '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                                            'title' => 'Update',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm ' . Yii::$app->params['btnClassFalcon'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage clients')) {
                                return Html::a(
                                                '<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                            'title' => 'Delete',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm ' . Yii::$app->params['btnClassFalcon'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this client?<br>'
                                                . 'The client will only be removed if they have no data associated to them',
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
                'id',
                'name',
                [
                    'attribute' => 'username',
                    'label' => 'Code',
                    'format' => 'raw',
                    'filter' => false,
                ],
                'address',
                 [
                    'attribute' => 'contact_person_first_name',
                    'format' => 'raw',
                    'filter' => false,
                    'value' => function ($model) {
                        return $model->contact_person_first_name . " " . $model->contact_person_last_name;
                    }
                ],
                'phone',
                'email:email',
                [
                    'attribute' => 'can_pay',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => ['Yes' => 'Yes', 'No' => 'No'],
                ],
                [
                    'class' => EditableColumn::className(),
                    'attribute' => 'active',
                    'filter' => false,
                    'readonly' => $read_only,
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [1 => 'Active', 0 => 'Inactive'],
                    'filterInputOptions' => ['prompt' => 'Filter by Status', 'class' => 'form-control', 'id' => null],
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'editableOptions' => [
                        'asPopover' => false,
                        'options' => ['class' => 'form-control', 'prompt' => 'Select Status'],
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data' => [1 => 'Active', 0 => 'Deactivate'],
                    ],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->active == 1) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Active</span><br>";
                        }
                        if ($model->active == 0) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Inactive</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                'created_at',
                'updated_at',
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
                                'class' => Yii::$app->params['btnClassFalcon'],
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
                                'class' => Yii::$app->params['btnClassFalcon'],
                                'title' => 'Export grid data',
                                'itemsBefore' => [
                                    '<div class="dropdown-header">Export All Data</div>',
                                ],
                            ],
                            'filename' => 'clientexport_' . date("dmYHis")
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

