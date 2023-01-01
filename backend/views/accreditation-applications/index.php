<?php

use backend\models\AccreditationApplications;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use kartik\export\ExportMenu;
use frontend\models\OrganisationContactPersons;
use frontend\models\OrganisationAreaOfExpertise;
use frontend\models\OrganisationRegistrationDetails;
use backend\models\User;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplicationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Consultative applications';
$this->params['breadcrumbs'][] = $this->title;
$fullExportMenu = "";
?>


<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">

        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'label' => 'Name',
                    'filter' => false
                ],
                [
                    'attribute' => 'organisation',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->organisation0->name;
                    }
                ],
                [
                    'attribute' => 'number',
                    'label' => 'Accreditation number',
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'income',
                    'label' => 'Income',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->currency0->iso_code . "" . number_format($model->income, 2);
                    }
                ],
                [
                    'attribute' => 'expenditure',
                    'label' => 'Expenditure',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->currency0->iso_code . "" . number_format($model->expenditure, 2);
                    }
                ],
                [
                    'attribute' => 'status',
                    'filter' => false,
                    'format' => "raw",
                    'enableSorting' => true,
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == AccreditationApplications::APPROVED) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::DIFFERED ||
                                $model->status == AccreditationApplications::DENIED) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::NOT_SUBMITTED) {
                            $str = "<span class='badge badge-soft-primary badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::SUBMITTED) {
                            $str = "<span class='badge badge-soft-info badge-pill ms-2'> "
                                    . "<i class='fas fa-check'></i> " . $model->status . " pending review</span><br>";
                        }
                        if ($model->status == AccreditationApplications::REVIEWED) {
                            $str = "<span class='badge badge-soft-info badge-pill ms-2'> "
                                    . "<i class='fas fa-check'></i> " . $model->status . " pending approval</span><br>";
                        }

                        return $str;
                    },
                ],
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:80px;', 'class' => "btn-group btn-group-sm"],
                    'template' => '{view}{review}{approve}{printcert}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(
                                    '<span class="fas fa-eye"></span>', ['view', 'id' => $model->id], [
                                'title' => 'View application',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'data-pjax' => '0',
                                'style' => "padding:5px;",
                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                    ]
                            );
                        },
                        'review' => function ($url, $model) {
                            if ($model->status == AccreditationApplications::SUBMITTED &&
                                    User::isUserAllowedTo("Review consultative accreditations")) {
                                return Html::a(
                                                '<span class="fas fa-spinner"></span>', ['review', 'id' => $model->id], [
                                            'title' => 'Review application',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'approve' => function ($url, $model) {
                            if ($model->status == AccreditationApplications::REVIEWED &&
                                    User::isUserAllowedTo("Approve accreditations applications")) {
                                return Html::a(
                                                '<span class="fas fa-edit"></span>', ['approve', 'id' => $model->id], [
                                            'title' => 'Approve application',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'printcert' => function ($url, $model) {
                            if ($model->status == AccreditationApplications::APPROVED) {
                                return Html::a(
                                                '<span class="fas fa-print"></span>', ['print-certificate', 'id' => $model->id], [
                                            'title' => 'Print accreditation certificate',
                                            'data-bs-toggle' => 'tooltip',
                                            'target' => '_blank',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
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
                    'attribute' => 'type',
                    'format' => 'raw',
                    'label' => 'Name',
                    'filter' => false
                ],
                [
                    'attribute' => 'organisation',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->organisation0->name;
                    }
                ],
                [
                    'attribute' => 'number',
                    'label' => 'Accreditation number',
                    'format' => 'raw',
                    'filter' => false,
                ],
                [
                    'attribute' => 'income',
                    'label' => 'Income',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->currency0->iso_code . "" . $model->income;
                    }
                ],
                [
                    'attribute' => 'expenditure',
                    'label' => 'Expenditure',
                    'format' => 'raw',
                    'filter' => false,
                    "value" => function ($model) {
                        return $model->currency0->iso_code . "" . $model->expenditure;
                    }
                ],
                [
                    'attribute' => 'status',
                    'filter' => false,
                    'enableSorting' => true,
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == AccreditationApplications::APPROVED) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::DIFFERED ||
                                $model->status == AccreditationApplications::DENIED) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::NOT_SUBMITTED) {
                            $str = "<span class='badge badge-soft-primary badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> " . $model->status . "</span><br>";
                        }
                        if ($model->status == AccreditationApplications::SUBMITTED) {
                            $str = "<span class='badge badge-soft-secondary badge-pill ms-2'> "
                                    . "<i class='fas fa-check'></i> " . $model->status . "</span><br>";
                        }

                        return $str;
                    },
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
                            'filename' => 'consultativeapplications_' . date("dmYHis")
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
