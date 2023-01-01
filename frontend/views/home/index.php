<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Organisations;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\widgets\FileInput;
use frontend\models\OrganisationAreaOfExpertise;
use yii\grid\ActionColumn;
use kartik\detail\DetailView;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$model = Organisations::findOne(Yii::$app->user->id);

?>

<div class="row g-3 mb-3">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header position-relative min-vh-25 mb-7">
                <div class="bg-holder rounded-2 rounded-bottom-0" style="background-image:url(<?= Url::to('@web/img/bg1.jpg') ?>);"></div>
                <!--/.bg-holder-->
                <div class="avatar avatar-5xl avatar-profile">
                    <?php
                    if (!empty($session->get('logo'))) {
                        echo Html::img('@web/uploads/' . $model->logo, ['class' => 'rounded-circle img-thumbnail shadow-sm']);
                    } else {
                        echo Html::img('@web/img/icon.png', ['class' => 'rounded-circle img-thumbnail shadow-sm']);
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="mb-1"> 
                            <?= $model->name; ?>
                            <span data-bs-toggle="tooltip" data-bs-placement="right" title="Account active">
                                <small class="fa fa-check-circle text-success" data-fa-transform="shrink-4 down-2"></small>
                            </span>
                        </h5>
                        <h5 class="fs-0 fw-normal">
                            <?= $model->type0->name ?>
                        </h5>
                        <p class="text-500">
                            <?= $model->postal_address . ', ' . $model->town . ", " . $model->country0->name ?>
                            <br>
                            Website: <a target="_blank" href="<?= $model->website ?>">
                                <?= $model->website ?>
                            </a>
                        </p>

                        <button class="btn btn-outline-primary btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#updateLogo">Update logo</button>
                        <div class="border-bottom border-dashed my-4 d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 pe-lg-2 mb-3">
        <div class="card mb-3">

            <div class="card-body bg-light">
                <div class="tab-content">
                    <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-1ada879e-dfbf-4f1f-80c9-26162e1a44ed" id="dom-1ada879e-dfbf-4f1f-80c9-26162e1a44ed">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile" aria-selected="true" >Profile</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#tab-areasofexpertise" role="tab" aria-controls="tab-areasofexpertise" aria-selected="false">Areas of expertise</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" id="regdetails-tab" data-bs-toggle="tab" href="#tab-regdetails" role="tab" aria-controls="tab-regdetails" aria-selected="false">Registration details</a></li>
                            <li class="nav-item"><a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#tab-contact" role="tab" aria-controls="tab-contact" aria-selected="false">Contact persons</a></li>
                        </ul>
                        <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Acronyms:</span> <span class="mb-1 text-primary"> <?= $model->acronym ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Email:</span> <span class="mb-1 text-primary"> <?= $model->email ?> </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Mobile:</span> <span class="mb-1 text-primary"> <?= $model->mobile ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Official language:</span> <span class="mb-1 text-primary"> <?= $model->officialLanguage->name ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Postal code:</span> <span class="mb-1 text-primary"> <?= $model->postal_code ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 p-2">
                                        <div class="flex-1 position-relative ps-3">
                                            <span class="text-1000 mb-0">Scope of operation:</span> <span class="mb-1 text-primary"> <?= $model->scope_of_operation ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">&nbsp;</div>
                                    <div class="col-sm-12">
                                        <?=
                                        Html::a('Update profile', ['update-profile', 'id' => $model->id], ["class" => 'btn btn-outline-success btn-sm px-3']);
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-areasofexpertise" role="tabpanel" aria-labelledby="areasofexpertise-tab">
                                <div class="row"> 
                                    <div class="col-lg-12"> 
                                        <button class="btn btn-outline-success btn-sm px-3" type="button" data-bs-toggle="modal" data-bs-target="#areaOfExpertise">
                                            Add area of expertise
                                        </button>
                                    </div>
                                    <div class="col-lg-12">&nbsp; </div>
                                    <div class="col-lg-12"> 
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $areasOfExpertise,
                                            'condensed' => true,
                                            'responsive' => true,
                                            'hover' => true,
                                            'panel' => [
                                                'type' => GridView::TYPE_DEFAULT,
                                            ],
                                            // set a label for default menu
                                            'export' => false,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'label' => 'Category',
                                                    'filter' => false,
                                                    'attribute' => 'category',
                                                    'format' => 'raw',
                                                    'group' => true,
                                                    'value' => function ($model) {
                                                        return $model->subCategory->category0->name;
                                                    },
                                                ],
                                                [
                                                    'label' => 'Sub category',
                                                    'attribute' => 'sub_category',
                                                    'filter' => false,
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->subCategory->name;
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'created_at',
                                                    'label' => 'Date created',
                                                    'value' => function ($model) {
                                                        return date('d F, Y', $model->created_at);
                                                    }
                                                ],
//                                                
                                                ['class' => ActionColumn::className(),
                                                    'options' => ['style' => 'width:100px;', 'class' => "btn-group btn-group-sm"],
                                                    'template' => '{delete}',
                                                    'buttons' => [
                                                        'delete' => function ($url, $model) {
                                                            return Html::a(
                                                                    '<span class="fas fa-trash-alt"></span>', ['delete-area-of-expertise', 'id' => $model->id], [
                                                                'title' => 'Delete',
                                                                'data-bs-toggle' => 'tooltip',
                                                                'data-bs-placement' => 'top',
                                                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                                                'data' => [
                                                                    'confirm' => 'Are you sure you want to delete area of expertise?',
                                                                    'method' => 'post',
                                                                ],
                                                                'style' => "padding:5px;",
                                                                    ]
                                                            );
                                                        },
                                                    ]
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-regdetails" role="tabpanel" aria-labelledby="regdetails-tab">
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
                                                        if (empty($registrationDetails)) {
                                                            echo Html::a('Add registration details', ['add-registration-details', 'id' => $model->id],
                                                                    [
                                                                        'title' => 'Add registration details',
                                                                        'data-bs-toggle' => 'tooltip',
                                                                        'data-bs-placement' => 'top',
                                                                        'class' => 'btn btn-outline-success'
                                                            ]);
                                                        } else {
                                                            echo Html::a('Update registration details', ['update-registration-details', 'id' => $registrationDetails->id],
                                                                    [
                                                                        'title' => 'Update registration details',
                                                                        'data-bs-toggle' => 'tooltip',
                                                                        'data-bs-placement' => 'top',
                                                                        'class' => 'btn btn-outline-success'
                                                            ]);
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
                                        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark">
                                            <?php
                                            if (!empty($registrationDetails)) {
                                                echo DetailView::widget([
                                                    'model' => $registrationDetails,
                                                    'valueColOptions' => ['style' => 'width:30%'],
                                                    'attributes' => [
                                                        [
                                                            'label' => 'Country',
                                                            'attribute' => 'country',
                                                            'value' => function () use ($registrationDetails) {
                                                                return $registrationDetails->country0->name;
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'number',
                                                        ],
                                                        [
                                                            'attribute' => 'years_of_experience',
                                                            'value' => function () use ($registrationDetails) {
                                                                return $registrationDetails->years_of_experience . " years";
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'registration_date',
                                                            'value' => function () use ($registrationDetails) {
                                                                return date('d F, Y', strtotime($registrationDetails->registration_date));
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'registration_expiry_date',
                                                            'value' => function () use ($registrationDetails) {
                                                                return date('d F, Y', strtotime($registrationDetails->registration_expiry_date));
                                                            }
                                                        ],
                                                        [
                                                            'label' => 'Created at ',
                                                            'value' => function () use ($registrationDetails) {
                                                                return date('d F, Y', $registrationDetails->created_at);
                                                            }
                                                        ],
                                                    ],
                                                ]);
                                            } else {
                                                echo '<div class="col-lg-12 py-3">'
                                                . '<span class="badge me-1 py-2 badge-soft-warning">Click add registration details button above to add registration details</span>'
                                                . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="col-lg-12"> 
                                    <?php
                                    echo Html::a('Add contact person', ['add-contact-person', 'id' => $model->id],
                                            [
                                                'title' => 'Add contact person',
                                                'data-bs-toggle' => 'tooltip',
                                                'data-bs-placement' => 'top',
                                                'class' => 'btn btn-outline-success btn-sm'
                                    ]);
                                    ?>
                                </div>
                                <div class="col-lg-12">&nbsp; </div>
                                <div class="col-lg-12"> 
                                    <?php
                                    if ($contactPersons->getCount() > 0) {
                                        echo GridView::widget([
                                            'dataProvider' => $contactPersons,
                                            'condensed' => true,
                                            'responsive' => true,
                                            'hover' => true,
                                            'panel' => [
                                                'type' => GridView::TYPE_DEFAULT,
                                            ],
                                            // set a label for default menu
                                            'export' => false,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],
                                                [
                                                    'label' => 'Name',
                                                    'filter' => false,
                                                    'attribute' => 'first_name',
                                                    'value' => function ($model) {
                                                        return $model->title . "" . $model->first_name . " " . $model->other_names . " " . $model->last_name . ', ' . $model->formal_title;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Department',
                                                    'filter' => false,
                                                    'attribute' => 'department',
                                                ],
                                                [
                                                    'label' => 'Country',
                                                    'filter' => false,
                                                    'attribute' => 'country',
                                                    'value' => function ($model) {
                                                        return $model->country0->name;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Contact Details',
                                                    'attribute' => 'telephone',
                                                    'filter' => false,
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        $str = '<span class="text-1000 mb-0 fs--3">Telephone:</span> <span class="mb-1 text-primary"> ' . $model->telephone . '</span><br>';
                                                        $str .= '<span class="text-1000 mb-0">Mobile:</span> <span class="mb-1 text-primary"> ' . $model->mobile . '</span><br>';
                                                        $str .= '<span class="text-1000 mb-0">Whatsapp number:</span> <span class="mb-1 text-primary"> ' . $model->whatsapp_number . '</span><br>';
                                                        $str .= '<span class="text-1000 mb-0">Fax:</span> <span class="mb-1 text-primary"> ' . $model->fax . '</span><br>';
                                                        $str .= '<span class="text-1000 mb-0">Email:</span> <span class="mb-1 text-primary"> ' . $model->email . '</span><br>';
                                                        return $str;
                                                    },
                                                ],
//                                                [
//                                                    'attribute' => 'created_at',
//                                                    'label' => 'Date created',
//                                                    'value' => function ($model) {
//                                                        return date('d F, Y', $model->created_at);
//                                                    }
//                                                ],
//                                                
                                                ['class' => ActionColumn::className(),
                                                    'options' => ['style' => 'width:130px;', 'class' => "btn-group btn-group-sm"],
                                                    'template' => '{update}{delete}',
                                                    'buttons' => [
                                                        'update' => function ($url, $model) {

                                                            return Html::a(
                                                                    '<span class="fas fa-edit"></span>', ['update-contact-person', 'id' => $model->id], [
                                                                'title' => 'Update',
                                                                'data-bs-toggle' => 'tooltip',
                                                                'data-bs-placement' => 'top',
                                                                'data-pjax' => '0',
                                                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                                                'style' => "padding:5px;",
                                                                    ]
                                                            );
                                                        },
                                                        'delete' => function ($url, $model) {
                                                            return Html::a(
                                                                    '<span class="fas fa-trash-alt"></span>', ['delete-contact-person', 'id' => $model->id], [
                                                                'title' => 'Remove',
                                                                'data-bs-toggle' => 'tooltip',
                                                                'data-bs-placement' => 'top',
                                                                'class' => 'col-auto btn-group btn-group-sm btn ' . Yii::$app->params['btnClass'],
                                                                'data' => [
                                                                    'confirm' => 'Are you sure you want to delete contact person?',
                                                                    'method' => 'post',
                                                                ],
                                                                'style' => "padding:5px;",
                                                                    ]
                                                            );
                                                        },
                                                    ]
                                                ],
                                            ],
                                        ]);
                                    } else {
                                        echo '<div class="col-lg-12 py-3">'
                                        . '<span class="badge me-1 py-2 badge-soft-warning">Click Add contact person button above to add contact person</span>'
                                        . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="areaOfExpertise" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="areaOfExpertiseLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="areaOfExpertiseLabel">Add Areas Of Expertise</h4>
                </div>
                <div class="p-4">
                    <div class="row">

                        <div class="col-lg-8">
                            <?php
                            $areaOfExpertiseModel = new OrganisationAreaOfExpertise();
                            $form2 = ActiveForm::begin(
                                            [
                                                'action' => 'add-area-of-expertise?id=' . $model->id,
                                                'type' => ActiveForm::TYPE_VERTICAL,
                                                'formConfig' =>
                                                [
                                                    'showRequiredIndicator' => true,
                                                ]
                            ]);
                            ?>
                            <?=
                            $form2->field($areaOfExpertiseModel, 'category', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'is-required',
                                    'style' => "font-weight:normal;",
                                ],
                            ])->widget(Select2::classname(), [
                                'data' => backend\models\Categories::getCategories(),
                                'options' => ['placeholder' => 'Select category', 'id' => 'category_id'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label("Category");
                            ?>
                            <?php
                            echo Html::hiddenInput('selected_id', $areaOfExpertiseModel->isNewRecord ? '' : $areaOfExpertiseModel->sub_category, ['id' => 'selected_id3']);

                            echo $form2->field($areaOfExpertiseModel, 'sub_category', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'is-required',
                                    'style' => "font-weight:normal;",
                                ],
                            ])->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_DEFAULT,
                                'options' => [
                                    'multiple' => true,
                                    'id' => 'subcategory_id',
                                    'custom' => true,
                                    'placeholder' => 'Select sub-cateories',
                                    'theme' => Select2::THEME_CLASSIC,
                                ],
                                'pluginOptions' => [
                                    'depends' => ['category_id'],
                                    'initialize' => $areaOfExpertiseModel->isNewRecord ? false : true,
                                    'placeholder' => 'Select sub-cateories',
                                    'url' => Url::to(['/home/subcategories']),
                                    'params' => ['selected_id'],
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <ol>
                                <li class="fs--1">You can pick multiple sub categories</li>
                                <li class="fs--1">Fields marked with <span class="text-danger">*</span> are required</li>
                            </ol>
                        </div>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="updateLogo" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateLogoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="updateLogoLabel">Update organisation logo</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <?php
                        $form1 = ActiveForm::begin(
                                        [
                                            'action' => 'update-logo?id=' . $model->id,
                                            'type' => ActiveForm::TYPE_VERTICAL,
                                            'formConfig' =>
                                            [
                                                'showRequiredIndicator' => true,
                                            ]
                        ]);
                        ?>
                        <?=
                        $form1->field($model, 'logo', [
                            'labelOptions' => [
                                'class' => 'is-required',
                                'style' => "font-weight:normal;",
                            ],
                        ])->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*', 'required' => true],
                            'pluginOptions' => [
                                'showPreview' => false,
                                'showCancel' => false,
                                'showUpload' => false,
                                'browseLabel' => 'Browse files',
                                'removeLabel' => '',
                                'mainClass' => 'input-group-lg',
                                'maxFileSize' => 10240,
                            ]
                        ])->label("Organisation logo")
                        ?>

                        <div class="col-lg-12">
                            <?= Html::submitButton('Update', ['class' => 'btn btn-success btn-md font-weight-bold font-size:18px;']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
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
                    <h4 class="mb-1" id="submitInfoLabel">Update organisation details</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>







