<?php

use backend\models\Requests;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use backend\models\Clients;

/** @var yii\web\View $this */
/** @var backend\models\RequestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Client requests';
$this->params['breadcrumbs'][] = $this->title;
$fullExportMenu = "";
?>
<div class="card mb-3">

    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                // 'id',
                [
                    'label' => 'Client',
                    'attribute' => 'client',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => Clients::getClients(),
                    'filterInputOptions' => ['prompt' => 'Filter by client', 'class' => 'form-control', 'id' => null],
                    'attribute' => 'client',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->client0->name, ['clients/view', 'id' => $model->client], [
                            'title' => 'View client',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                                ]
                        );
                    },
                ],
                [
                    'label' => 'Path',
                    'filter' => false,
                    'attribute' => 'request',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'amount',
                    'label' => 'Charge',
                    'value' => function ($model) {
                        return "ZMW" . $model->amount;
                    },
                    'filter' => false,
                ],
                [
                    'attribute' => 'status',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [200 => 'Success', 201 => 'Failed'],
                    'filterInputOptions' => ['prompt' => 'Filter', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == 200) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Success</span><br>";
                        }
                        if ($model->status == 201) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Failed</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'payment_status',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [1 => 'Paid', 0 => 'Pending'],
                    'filterInputOptions' => ['prompt' => 'Filter', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == 200 && $model->payment_status == 1) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Paid</span><br>";
                        } else {
                            $str = "<span class='badge badge-soft-warning badge-pill ms-2'> "
                                    . "<i class='fas fa-hourglass-half'></i> Pending</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Date',
                    'attribute' => 'created_at',
                    'headerOptions' => ['style' => ''],
                    'filter' => false,
                    'format' => 'raw',
                    'filter' => kartik\daterange\DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'convertFormat' => true,
                        'includeMonthsFilter' => true,
                        'attribute' => 'created_at',
                        'model' => $searchModel,
                        'pluginOptions' => ['locale' => [
                                'format' => 'Y-m-d',
                                'separator' => ' to ',
                            ]],
                        'options' => ['placeholder' => '']
                    ]),
                    //  'filter' => [213 => 'Pending', 215 => 'Success', 214 => "Failed"],
                    'filterInputOptions' => ['prompt' => 'Filter by date', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', strtotime($model->created_at));
                    }
                ],
                [
                    'attribute' => 'source_ip',
                    'filter' => false,
                ],
                [
                    'attribute' => 'source_agent',
                    'filter' => false,
                ],
//                ['class' => ActionColumn::className(),
//                    'options' => ['style' => 'width:80px;', 'class' => "btn-group btn-group-sm"],
//                    'template' => '{view}',
//                    'buttons' => [
//                        'view' => function ($url, $model) {
//                            return Html::a(
//                                    '<span class="fas fa-eye"></span>', ['view', 'id' => $model->id], [
//                                'title' => 'View',
//                                'data-bs-toggle' => 'tooltip',
//                                'data-bs-placement' => 'top',
//                                'data-pjax' => '0',
//                                'style' => "padding:5px;",
//                                'class' => 'col-auto btn-group btn-group-sm ' . Yii::$app->params['btnClassFalcon'],
//                                    ]
//                            );
//                        },
//                    ]
//                ],
            ];
            $gridColumns1 = [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'label' => 'Client',
                    'attribute' => 'client',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => Clients::getClients(),
                    'filterInputOptions' => ['prompt' => 'Filter by client', 'class' => 'form-control', 'id' => null],
                    'attribute' => 'client',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->client0->name;
                    }
                ],
                [
                    'label' => 'Path',
                    'filter' => false,
                    'attribute' => 'request',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'amount',
                    'label' => 'Charge',
                    'value' => function ($model) {
                        return "ZMW" . $model->amount;
                    },
                    'filter' => false,
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [200 => 'Success', 201 => 'Failed'],
                    'filterInputOptions' => ['prompt' => 'Filter by Status', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == 200) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Success</span><br>";
                        }
                        if ($model->status == 201) {
                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                    . "<i class='fas fa-times'></i> Failed</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'payment_status',
                    'label' => 'Payment status',
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filter' => [1 => 'Paid', 0 => 'Pending'],
                    'filterInputOptions' => ['prompt' => 'Filter', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        $str = "";
                        if ($model->status == 200 && $model->payment_status == 1) {
                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                    . "<i class='fas fa-check'></i> Paid</span><br>";
                        } else {
                            $str = "<span class='badge badge-soft-warning badge-pill ms-2'> "
                                    . "<i class='fas fa-hourglass-half'></i> Pending</span><br>";
                        }

                        return $str;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Date',
                    'attribute' => 'created_at',
                    'headerOptions' => ['style' => ''],
                    'filter' => false,
                    'format' => 'raw',
                    'filter' => kartik\daterange\DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'convertFormat' => true,
                        'includeMonthsFilter' => true,
                        'attribute' => 'created_at',
                        'model' => $searchModel,
                        'pluginOptions' => ['locale' => [
                                'format' => 'Y-m-d',
                                'separator' => ' to ',
                            ]],
                        'options' => ['placeholder' => '']
                    ]),
                    //  'filter' => [213 => 'Pending', 215 => 'Success', 214 => "Failed"],
                    'filterInputOptions' => ['prompt' => 'Filter by date', 'class' => 'form-control', 'id' => null],
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', strtotime($model->created_at));
                    }
                ],
                [
                    'attribute' => 'source_ip',
                    'filter' => false,
                ],
                [
                    'attribute' => 'source_agent',
                    'filter' => false,
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
                            'filename' => 'clientrequestexport_' . date("dmYHis")
                ]);
            }

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'options' => ['style' => 'font-size:16px;'],
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

