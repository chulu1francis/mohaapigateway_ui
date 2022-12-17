<?php

use backend\models\AauthGroups;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use backend\models\User;
use backend\models\AauthPermToGroup;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User groups';
$this->params['breadcrumbs'][] = $this->title;
$fullExportMenu = "";
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
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage groups')) {
                            echo Html::a('<span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Add group', ['create'],
                                    [
                                        'class' => 'btn ' . Yii::$app->params['btnClass'] . ' me-1 mb-1',
                                        'title' => 'Add user group',
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
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => AauthGroups::getGroupList(),
                    'filterInputOptions' => ['prompt' => 'Filter by group', 'class' => 'form-control', 'id' => null],
                ],
                [
                    'label' => 'Rights',
                    'value' => function ($model) {
                        $rightsArray = AauthPermToGroup::getGroupPermissions($model->id);
                        return implode(", ", $rightsArray);
                    }
                ],
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:100px;', 'class' => "btn-group btn-group-sm"],
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
                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                    ]
                            );
                        },
                        'update' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage groups')) {
                                return Html::a(
                                                '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                                            'title' => 'Update',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage groups')) {
                                return Html::a(
                                                '<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                            'title' => 'Delete',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this user group?<br>'
                                                . 'The group will only be removed if no user is assigned to the group',
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
                    'attribute' => 'name',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => AauthGroups::getGroupList(),
                    'filterInputOptions' => ['prompt' => 'Filter by group', 'class' => 'form-control', 'id' => null],
                ],
                [
                    'label' => 'Rights',
                    'value' => function ($model) {
                        $rightsArray = AauthPermToGroup::getGroupPermissions($model->id);
                        return implode(", ", $rightsArray);
                    }
                ],
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:100px;', 'class' => "btn-group btn-group-sm"],
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
                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                    ]
                            );
                        },
                        'update' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage groups')) {
                                return Html::a(
                                                '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                                            'title' => 'Update',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage groups')) {
                                return Html::a(
                                                '<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                            'title' => 'Delete',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this user group?',
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
                            'filename' => 'usergroups_' . date("dmYHis")
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
