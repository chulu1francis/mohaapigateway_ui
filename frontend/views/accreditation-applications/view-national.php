<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use \backend\models\AccreditationApplications;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */
$this->title = "View";
$this->params['breadcrumbs'][] = ['label' => 'My National applications', 'url' => ['national']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">

                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3" id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if ($model->status == AccreditationApplications::NOT_SUBMITTED) {
                            echo Html::a('<span class="fas fa-edit"></span>', ['update-national', 'id' => $model->id],
                                    [
                                        'title' => 'Update',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn ' . Yii::$app->params['btnClass']
                            ]);
                        }
                        if ($model->status == AccreditationApplications::APPROVED) {
                            echo Html::a('<span class="fas fa-print"></span>', ['update', 'id' => $model->id],
                                    [
                                        'title' => 'Print accreditation certificate',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn ' . Yii::$app->params['btnClass']
                            ]);
                        }
                        if ($model->status == AccreditationApplications::NOT_SUBMITTED) {
                            echo Html::a('<span class="fas fa-paper-plane"></span>', ['submit-application', 'id' => $model->id, 'type' => 1], [
                                'title' => 'Submit for approval',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'class' => 'btn ' . Yii::$app->params['btnClass'],
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit this application for approval?<br>'
                                    . 'You will not be able to make changes when submitted',
                                    'method' => 'post',
                                ],
                            ]);
                        }

                        //This is a hack, just to use pjax for the delete confirm button
                        $query = \backend\models\User::find()->where(['id' => '-2']);
                        $dataProvider1 = new \yii\data\ActiveDataProvider([
                            'query' => $query,
                        ]);
                        GridView::widget([
                            'dataProvider' => $dataProvider1,
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                            ],
                            'export' => false,
                            'exportContainer' => [
                                'class' => 'form-select js-choice'
                            ],
                        ]);
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
                'valueColOptions' => ['style' => 'width:30%'],
                'attributes' => [
                    [
                        'label' => 'Name',
                        'attribute' => 'type',
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
                        "value" => function () use ($model) {
                            return $model->currency0->iso_code . "" . number_format($model->income, 2);
                        }
                    ],
                    [
                        'attribute' => 'expenditure',
                        'label' => 'Expenditure',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return $model->currency0->iso_code . "" . number_format($model->expenditure, 2);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => false,
                        'format' => "raw",
                        'enableSorting' => true,
                        'value' => function () use ($model) {
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
                        'attribute' => 'letter',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->letter,
                                'filename' => $model->organisation0->name . '_applicationletter',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View application letter',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'registration_or_acknowledgement_certificate',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->registration_or_acknowledgement_certificate,
                                'filename' => $model->organisation0->name . '_registration_certificate',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View registration certificate',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'certified_articles_of_association',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->certified_articles_of_association,
                                'filename' => $model->organisation0->name . '_articlesofassociation',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View articles of association',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'bylaws',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->bylaws,
                                'filename' => $model->organisation0->name . '_bylaws',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View by laws',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'statutes_or_constitution_detailing_the_mandate',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->statutes_or_constitution_detailing_the_mandate,
                                'filename' => $model->organisation0->name . '_statutesorconstitution',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View statutes or constitution',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'scope_and_governing_structure_or_organisational_profile',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->scope_and_governing_structure_or_organisational_profile,
                                'filename' => $model->organisation0->name . '_scopeandgoverningstructure',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View scope and governing structure',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'annual_income_and_expenditure_statement',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->annual_income_and_expenditure_statement,
                                'filename' => $model->organisation0->name . '_incomestatement',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View income and expenditure statement',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'names_of_all_donors_and_other_funding_sources_last_two_years',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->names_of_all_donors_and_other_funding_sources_last_two_years,
                                'filename' => $model->organisation0->name . '_namesofdonors',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View names of donors and other funding',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'evidence_of_competency_in_thematic_areas',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->evidence_of_competency_in_thematic_areas,
                                'filename' => $model->organisation0->name . '_evidenceofcompetencyinthematicarea',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View evidence of competency',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'other_relevant_documents',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return Html::a('View document', ['download',
                                'file' => $model->other_relevant_documents,
                                'filename' => $model->organisation0->name . '_otherdocuments',
                                'folder' => 'nationalfiles'],
                                    [
                                        'title' => 'View other relevant documents',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn btn-outline-success btn-sm',
                                        'target' => '_blank',
                            ]);
                        }
                    ],
                    [
                        'attribute' => 'compliance_with_au_data_policy',
                        'format' => 'raw',
                        'filter' => false,
                        "value" => function () use ($model) {
                            return $model->compliance_with_au_data_policy == 1 ? "<span class='badge badge-soft-success badge-pill ms-2'> "
                            . "<i class='fas fa-check'></i> Yes</span>" : "<span class='badge badge-soft-danger badge-pill ms-2'> "
                            . "<i class='fas fa-times'></i> No</span>";
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Created at',
                        'value' => function () use ($model) {
                            return date('d F, Y', $model->created_at);
                        }
                    ],
                ],
            ])
            ?>
        </div>
    </div>
</div>
