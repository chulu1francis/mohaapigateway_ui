<?php

use frontend\models\OrganisationAreaOfExpertise;
use frontend\models\OrganisationRegistrationDetails;
use frontend\models\OrganisationContactPersons;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\detail\DetailView;

$areasOfExpertise = OrganisationAreaOfExpertise::find()
        ->where(['organisation' => $model->id])
        ->orderBy('created_at DESC');

$registrationDetails = OrganisationRegistrationDetails::findOne(['organisation' => $model->id]);
$query = OrganisationContactPersons::find()
        ->where(['organisation' => $model->id]);
$dataProviderContactPersons = new ActiveDataProvider(['query' => $query,]);
$dataProvider = new ActiveDataProvider(['query' => $areasOfExpertise,]);
?>

<div class="row g-3 mb-3">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header position-relative min-vh-25 mb-7">
                <div class="bg-holder rounded-2 rounded-bottom-0" style="background-image:url(<?= Url::to('@web/img/bg1.jpg') ?>);"></div>
                <!--/.bg-holder-->
                <div class="avatar avatar-5xl avatar-profile">
                    <?php
                    if (!empty($model->logo)) {
                        ?>
                        <img class="rounded-circle img-thumbnail shadow-sm" src="<?= Url::to(Yii::$app->request->hostInfo . '/img/logo.png') ?>" />
                        <?php
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
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-areasofexpertise" role="tabpanel" aria-labelledby="areasofexpertise-tab">
                                <div class="row"> 
                                    <div class="col-lg-12">&nbsp; </div>
                                    <div class="col-lg-12"> 
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
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
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-regdetails" role="tabpanel" aria-labelledby="regdetails-tab">
                                <div class="card mb-3">

                                    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
                                        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark">
                                            <?php
                                            if (!empty($registrationDetails)) {
                                                echo DetailView::widget([
                                                    'model' => $registrationDetails,
                                                    'valueColOptions' => ['style' => 'width:30%;font-size:15px;'],
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
                                                . '<span class="badge me-1 py-2 badge-soft-warning">Not added yet!</span>'
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
                                    if ($dataProviderContactPersons->count > 0) {
                                        echo GridView::widget([
                                            'dataProvider' => $dataProviderContactPersons,
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
                                            ],
                                        ]);
                                    } else {
                                        echo '<div class="col-lg-12 py-3">'
                                        . '<span class="badge me-1 py-2 badge-soft-warning">Not added yet!</span>'
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
