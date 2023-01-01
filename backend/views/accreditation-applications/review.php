<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use \backend\models\AccreditationApplications;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use frontend\models\Organisations;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */
$this->title = "Review " . $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Consultative applications', 'url' => ['consultative']];
$this->params['breadcrumbs'][] = $model->type;
\yii\web\YiiAsset::register($this);
?>
 
<div class="card mb-3">
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark">
            <div class="row">            
                <div class="col-lg-8">            
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'valueColOptions' => ['style' => 'width:15%;font-size:14px;'],
                        'attributes' => [
                            [
                                'label' => 'Name',
                                'attribute' => 'type',
                            ],
                            [
                                'attribute' => 'organisation',
                                'format' => 'raw',
                                'filter' => false,
                                'format' => 'raw',
                                "value" => function () use ($model) {
                                    return $model->organisation0->name . '<br>'
                                    . '<button class="btn btn-outline-success btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#submitInfo">View full details</button>';
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                                        'folder' => 'consultativefiles'],
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
                <div class="col-lg-4">
                    <h4>Review</h4>
                    <p>The review is final and after which the application goes for approval</p>
                    <hr>
                    <?php
                    $form = ActiveForm::begin(
                                    ['action' => 'review?id=' . $model->id,]);
                    ?>
                    <?=
                    $form->field($reviewModel, 'dueDiligenceReport', [
                        'labelOptions' => [
                            'class' => 'is-required',
                            'style' => "font-weight:normal;",
                        ],
                    ])->widget(FileInput::classname(), [
                        'options' => ['accept' => 'application/pdf', 'required' => true],
                        'pluginOptions' => [
                            'showPreview' => false,
                            'showCancel' => false,
                            'showUpload' => false,
                            'browseLabel' => 'Browse files',
                            'removeLabel' => '',
                            'mainClass' => 'input-group-lg',
                            'maxFileSize' => 20480,
                        ]
                    ])
                    ?>
                    <?=
                    $form->field($reviewModel, 'remarks', [])->textArea(['id' => "remarks", 'maxlength' => true, "rows" => 8, "Placeholder" => "Enter your remarks"])->label(FALSE)
                    ?>
                    <?=
                    $form->field($reviewModel, 'recommendation')->radioList(
                            [
                                1 => "Accepted",
                                2 => "Differed",
                                3 => 'Declined'
                            ],
                            [
                                'custom' => true,
                                'id' => 'custom-radio-list',
                                'inline' => true,
                                'labelSpan' => '10px'
                            ]
                    );
                    ?>
                    <div class="col-lg-12">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
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
                    <h4 class="mb-1" id="submitInfoLabel">Organisation details</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $this->render('organisation', ['model' => Organisations::findOne($model->organisation)]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
