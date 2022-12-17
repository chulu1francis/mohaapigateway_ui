<?php

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
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$read_only = true;
$fullExportMenu = "";
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <h5 class="fs-0 px-3 pt-3 pb-2 mb-0 ">Instructions</h5>
                    <ol>
                        <li class="falcon-card-color fs--1">
                            If user LMS account status is saying <span class="badge badge-soft-danger">Not created</span>, you can click the icon <span class="far fa-paper-plane"></span> next to the user to create the account
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage users')) {
                            $read_only = false;
                            echo Html::a('<span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Add user', ['create'],
                                    [
                                        'class' => 'btn ' . Yii::$app->params['btnClass'] . ' me-1 mb-1',
                                        'title' => 'Add new user',
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
                    'attribute' => 'group',
                    'format' => 'raw',
                    'label' => 'Group',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => AauthGroups::getGroups(),
                    'filterInputOptions' => ['prompt' => 'Filter by group', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        return $model->group0->name;
                    },
                ],
                [
                    'attribute' => 'first_name',
                    'label' => 'Names',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => User::getFullNames(),
                    'filterInputOptions' => ['prompt' => 'Filter by names', 'class' => 'form-control', 'id' => null],
                    "value" => function ($model) {
                        return $model->first_name . " " . $model->other_name . " " . $model->last_name;
                    }
                ],
                [
                    'attribute' => 'man_number',
                    'label' => 'Man no',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => User::getManNumbers(),
                    'filterInputOptions' => ['prompt' => 'Filter by man no', 'class' => 'form-control', 'id' => null],
                ],
                [
                    'attribute' => 'department',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => Departments::getDepartments(),
                    'filterInputOptions' => ['prompt' => 'Filter by department', 'class' => 'form-control', 'id' => null],
                    "value" => function ($model) {
                        return $model->department0->name;
                    }
                ],
                [
                    'attribute' => 'expiry_date',
                    'format' => 'raw',
                    'filter' => false,
                    'value' => function ($model) {
                        $str = "";
                        if ($model->expiry_date < date("Y-m-d")) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Expired</span><br>";
                        } else {
                            $str = $model->expiry_date;
                        }

                        return $str;
                    },
                ],
                [
                    'attribute' => 'lms_account_created',
                    'format' => 'raw',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => ["Yes" => 'Created', "No" => 'Not created'],
                    'filterInputOptions' => ['prompt' => 'Filter by LMS status', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->lms_account_created == "Yes") {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> created</span><br>";
                        } else {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Not created</span>&nbsp;&nbsp;";
                        }

                        return $str;
                    },
                ],
                [
                    //  'class' => EditableColumn::className(),
                    'attribute' => 'active',
                    'filter' => false,
                    'readonly' => $read_only,
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [User::STATUS_ACTIVE => 'Active', User::STATUS_INACTIVE => 'Deactivated', User::STATUS_SUSPENDED => 'Suspended'],
                    'filterInputOptions' => ['prompt' => 'Filter by Status', 'class' => 'form-control', 'id' => null],
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'editableOptions' => [
                        'asPopover' => false,
                        'options' => ['class' => 'form-control', 'prompt' => 'Select Status'],
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data' => [User::STATUS_ACTIVE => 'Active', User::STATUS_INACTIVE => 'Deactivated', User::STATUS_SUSPENDED => 'Suspended'],
                    ],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->active == User::STATUS_ACTIVE) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Active</span><br>";
                        }
                        if ($model->active == User::STATUS_INACTIVE) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Inactive</span><br>";
                        }
                        if ($model->active == User::STATUS_SUSPENDED) {
                            $str = "<span class='badge badge-soft-warning badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Suspended</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                //'email:ntext',
                //'active',
                //'updated_by',
                //'created_by',
                //'created_at',
                //'updated_at',
                //'expiry_date',
                //'username',
                //'last_login',
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:80px;', 'class' => "btn-group btn-group-sm"],
                    'template' => '{lmsaccount}{view}{update}{delete}',
                    'buttons' => [
                        'lmsaccount' => function ($url, $model) {
                            if (User::isUserAllowedTo('Manage users') && $model->lms_account_created == "No") {
                                return Html::a(
                                                '<span class="far fa-paper-plane"></span>', ['lms-account', 'id' => $model->id,'origin'=>"index"], [
                                            'title' => 'Create LMS account',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to create an LMS account for this user?<br>'
                                                . 'The system will attempt to create an account on the LMS',
                                                'method' => 'post',
                                            ],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
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
                            if (User::isUserAllowedTo('Manage users')) {
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
                            if (User::isUserAllowedTo('Manage users')) {
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
                'id',
                'group',
                'first_name',
                'last_name',
                'phone',
                    //'email:ntext',
                    //'active',
                    //'auth_key',
                    //'password_hash:ntext',
                    //'password_reset_token',
                    //'verification_token:ntext',
                    //'ip_address:ntext',
                    //'login_attempts',
                    //'updated_by',
                    //'created_by',
                    //'created_at',
                    //'updated_at',
                    //'man_number',
                    //'expiry_date',
                    //'department',
                    //'username',
                    //'last_login',
                    //'lms_account_created',
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
                            'filename' => 'users_' . date("dmYHis")
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
