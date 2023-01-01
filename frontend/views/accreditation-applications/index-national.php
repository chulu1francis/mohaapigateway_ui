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

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplicationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'National applications';
$this->params['breadcrumbs'][] = $this->title;
$fullExportMenu = "";
$contactPersons = OrganisationContactPersons::find()->where(['organisation' => Yii::$app->user->id])->one();
$areasOfExpertise = OrganisationAreaOfExpertise::find()->where(['organisation' => Yii::$app->user->id])->one();
$organisationRegistrationDetails = OrganisationRegistrationDetails::findOne(['organisation' => Yii::$app->user->id]);
$Application = AccreditationApplications::find()->
                where(['organisation' => Yii::$app->user->id])
                ->andWhere(['IN', "status", [AccreditationApplications::NOT_SUBMITTED,
                        AccreditationApplications::SUBMITTED,
                        AccreditationApplications::APPROVED, AccreditationApplications::DIFFERED]])
                ->andWhere(['type' => "National"])->one();
?>


<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <?php
                    if (empty($contactPersons) || empty($areasOfExpertise) || empty($organisationRegistrationDetails)) {
                        echo '<span class="badge badge-soft-warning fs--1">
                        Your Profile is not complete. Please complete your organisation profile before making an application
                    </span>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (!empty($contactPersons) && !empty($areasOfExpertise) && !empty($organisationRegistrationDetails)) {
                            if (empty($Application)) {
                                echo Html::a('<span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Apply for national', ['create-national'],
                                        [
                                            'class' => 'btn btn-outline-success btn-sm me-1 mb-1',
                                            'title' => 'Apply',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                ]);
                            }
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
                    'attribute' => 'type',
                    'format' => 'raw',
                    'label' => 'Name',
                    'filter' => false
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
                    'template' => '{view}{update}{submit}{printcert}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(
                                    '<span class="fas fa-eye"></span>', ['view-national', 'id' => $model->id], [
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
                            if ($model->status == "Not submitted") {
                                return Html::a(
                                                '<span class="fas fa-edit"></span>', ['update-national', 'id' => $model->id], [
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
                        'printcert' => function ($url, $model) {
                            if ($model->status == AccreditationApplications::APPROVED) {
                                return Html::a(
                                                '<span class="fas fa-print"></span>', ['update', 'id' => $model->id], [
                                            'title' => 'Print accreditation certificate',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'data-pjax' => '0',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'style' => "padding:5px;",
                                                ]
                                );
                            }
                        },
                        'submit' => function ($url, $model) {
                            if ($model->status == "Not submitted") {
                                return Html::a(
                                                '<span class="fas fa-paper-plane"></span>', ['submit-application', 'id' => $model->id, 'type' => 1], [
                                            'title' => 'Submit for approval',
                                            'data-bs-toggle' => 'tooltip',
                                            'data-bs-placement' => 'top',
                                            'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                            'data' => [
                                                'confirm' => 'Are you sure you want to submit this application for approval?<br>'
                                                . 'You will not be able to make changes when submitted',
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
                    'attribute' => 'type',
                    'format' => 'raw',
                    'label' => 'Name',
                    'filter' => false
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
                            'filename' => 'nationalapplications_' . date("dmYHis")
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
