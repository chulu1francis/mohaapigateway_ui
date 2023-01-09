<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;
use backend\models\AcreditationApplicationApprovals;
use backend\models\AccreditationApplications;
use yii\data\ActiveDataProvider;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$count = 0;
$dataProviderApplications = "";
$dataProviderConsultativeApplicationsApproval = "";

if (User::isUserAllowedTo('Review consultative accreditations') ||
        User::isUserAllowedTo('Review national accreditations')) {
    $approvalStatuses = AcreditationApplicationApprovals::find()
            ->where(['status_accreditation_officer' => 0])
            ->asArray()
            ->all();
    
    if (!empty($approvalStatuses)) {
        $applicationIds = [];
        foreach ($approvalStatuses as $approval) {
            array_push($applicationIds, $approval['id']);
        }

        $query = AccreditationApplications::find()
                ->where(['status' => AccreditationApplications::SUBMITTED])
                ->andWhere(['IN', 'id', $applicationIds]);
        $dataProviderApplications = new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    if (!empty($dataProviderApplications) && $dataProviderApplications->count > 0) {
        $count++;
    }
}
if (User::isUserAllowedTo('Approve accreditations applications')) {
    $approvalStatuses = AcreditationApplicationApprovals::find()
            ->where(["NOT IN", 'status_accreditation_officer', [0]])
            ->asArray()
            ->all();
    if (!empty($approvalStatuses)) {
        $applicationIds = [];
        foreach ($approvalStatuses as $approval) {
            array_push($applicationIds, $approval['id']);
        }

        $query = AccreditationApplications::find()
                ->where(['status' => AccreditationApplications::REVIEWED])
                ->andWhere(['IN', 'id', $applicationIds]);
        $dataProviderConsultativeApplicationsApproval = new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    if (!empty($dataProviderConsultativeApplicationsApproval) && $dataProviderConsultativeApplicationsApproval->count > 0) {
        $count++;
    }
}

?>


<div class="col-lg-12 pe-lg-2 mb-3">
    <div class="card h-lg-100 overflow-hidden">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0">Your tasks</h6>
                </div>
            </div>
        </div>
        <div class="card-body fs-0 border-top border-200 p-0">
            <?php
            if ($count > 0) {
                if (!empty($dataProviderApplications) && $dataProviderApplications->count > 0) {
                    echo ' <div class="col-lg-12 mb3">
                        <h4 class="fs-1 px-3 pt-3 pb-2 mb-0 ">Accreditation applications pending review</h4>
                        <ol>
                           <li class="falcon-card-color fs-0">Click the "Review" link under the Action column to go to the review page</li>
                        </ol>
                        <hr class="dotted short">
                    ';

                    echo '<div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">';
                    echo GridView::widget([
                        'dataProvider' => $dataProviderApplications,
                        'export' => false,
                        'exportContainer' => [
                            'class' => 'form-select js-choice'
                        ],
                        'hover' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'organisation',
                                'format' => 'raw',
                                'label' => 'Organisation',
                                'filter' => false,
                                "value" => function ($model) {
                                    return $model->organisation0->name;
                                }
                            ],
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'label' => 'Name',
                                'filter' => false
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

                                    return $str;
                                },
                            ],
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'value' => function ($model) {
                                     $route = $model->type == "National" ? "review-national" : "review";
                                    return Html::a("Review", ["accreditation-applications/".$route, 'id' => $model->id]);
                                }
                            ]
                        ],
                    ]);
                    echo "</div>";
                }

                if (!empty($dataProviderConsultativeApplicationsApproval) && $dataProviderConsultativeApplicationsApproval->count > 0) {
                    echo ' <div class="col-lg-12 mb3">
                        <h4 class="fs-1 px-3 pt-3 pb-2 mb-0 ">Accreditation applications pending approval</h4>
                        <ol>
                           <li class="falcon-card-color fs-0">Click the "Approve" link under the Action column to go to the approval page</li>
                        </ol>
                        <hr class="dotted short">
                    ';

                    echo '<div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">';
                    echo GridView::widget([
                        'dataProvider' => $dataProviderConsultativeApplicationsApproval,
                        'export' => false,
                        'exportContainer' => [
                            'class' => 'form-select js-choice'
                        ],
                        'hover' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'organisation',
                                'format' => 'raw',
                                'label' => 'Organisation',
                                'filter' => false,
                                "value" => function ($model) {
                                    return $model->organisation0->name;
                                }
                            ],
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'label' => 'Name',
                                'filter' => false
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
                            [
                                'attribute' => 'Action',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $route = $model->type == "National" ? "approve-national" : "approve";
                                    return Html::a("Approve", ["accreditation-applications/" . $route, 'id' => $model->id]);
                                }
                            ]
                        ],
                    ]);
                    echo "</div>";
                }
                ?>

            <?php } ?>

            <?php if ($count == 0) { ?>
                <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                    <div class="col ps-card py-1 position-static">
                        <h6 class="text-700 mb-0">
                            You have no pending tasks to perform!
                        </h6>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>




