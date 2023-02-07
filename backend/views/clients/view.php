<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\models\User;
use backend\models\Requests;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use backend\models\AvailableAttributes;
use kartik\form\ActiveForm;
use \yii\data\ArrayDataProvider;
Use backend\models\AvailableEndpoints;
use backend\models\ClientEndpoints;

/** @var yii\web\View $this */
/** @var backend\models\Clients $model */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$amountOwing = Requests::find()
        ->select(['amount'])
        ->where(['client' => $model->id])
        ->andWhere(['payment_status' => 0])
        ->sum('amount');

$clientRequests = $model->requests;

$dataProvider = new ArrayDataProvider([
    'allModels' => $clientRequests,
    'sort' => [
        'attributes' => ['id'],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
        ]);

$clientUsers = $model->clientUsers;

$dataProviderClientUsers = new ArrayDataProvider([
    'allModels' => $clientUsers,
    'sort' => [
        'attributes' => ['id'],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
        ]);
$cache = Yii::$app->redis;
?>


<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <?php
                    if ($model->can_pay == "Yes") {
                        ?>
                        <span class="fs-1">
                            Total request charges ZMW 
                        </span>
                        <span class="fs-3 fw-bolder text-danger" data-countup='{"endValue":<?= $amountOwing ?>}'>
                            0
                        </span>
                        <?php
//                    if (Yii::$app->getUser()->identity->group0->name == "ADMIN" && $amountOwing > 0) {
//                        echo '<a class="btn btn-success btn-sm p-1" type="button" data-bs-toggle="modal" data-bs-target="#submitInfo">
//                              Settle ZMW ' . $amountOwing . '
//                            </a>';
//                    }
                    }
                    ?>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3" id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage clients')) {
                            echo Html::a('<span class="fas fa-edit"></span>', ['update', 'id' => $model->id],
                                    [
                                        'title' => 'Update client',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => Yii::$app->params['btnClassFalcon']
                            ]);
                            echo Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                                'title' => 'Delete client',
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'class' => Yii::$app->params['btnClassFalcon'],
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this client?<br>'
                                    . 'The client will only be removed if they have no data associated to them',
                                    'method' => 'post',
                                ],
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
            <div class="row">
                <div class="col-lg-5">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'valueColOptions' => ['style' => 'width:25%;font-size:14px;'],
                        'attributes' => [
                            'name',
                            [
                                'attribute' => 'username',
                                'label' => 'Code',
                                'format' => 'raw',
                                'filter' => false,
                            ],
                            'address',
                            [
                                'attribute' => 'contact_person_first_name',
                                'label' => 'Contact person',
                                'format' => 'raw',
                                'filter' => false,
                                'value' => function () use ($model) {
                                    return $model->contact_person_first_name . " " . $model->contact_person_last_name;
                                }
                            ],
                            'phone',
                            'email:email',
                            [
                                'attribute' => 'can_pay',
                            ],
                            [
                                'attribute' => 'active',
                                'value' => function () use ($model) {
                                    $str = "";
                                    if ($model->active == 1) {
                                        $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                                . "<i class='fas fa-check'></i> Active</span><br>";
                                    }
                                    if ($model->active == 0) {
                                        $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                                . "<i class='fas fa-times'></i> Inactive</span><br>";
                                    }

                                    return $str;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Created by',
                                'attribute' => 'created_by',
                                'value' => function () use ($model) {
                                    $user = !empty($model->createdBy) ? $model->createdBy->title . $model->createdBy->first_name . " " . $model->createdBy->last_name : '';
                                    return $user;
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Created at',
                                'value' => function () use ($model) {
                                    return date('d F, Y H:i:s', strtotime($model->created_at));
                                }
                            ],
                            [
                                'label' => 'Last modified by',
                                'value' => function () use ($model) {
                                    $user = !empty($model->updatedBy) ? $model->updatedBy->title . $model->updatedBy->first_name . " " . $model->updatedBy->last_name : "";
                                    return $user;
                                }
                            ],
                            [
                                'label' => 'Last modified ',
                                'value' => function () use ($model) {
                                    return date('d F, Y H:i:s', strtotime($model->updated_at));
                                }
                            ],
                        ],
                    ])
                    ?>
                </div>
                <div class="col-lg-7">
                    <div class="tab-content">
                        <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-1ada879e-dfbf-4f1f-80c9-26162e1a44ed" id="dom-1ada879e-dfbf-4f1f-80c9-26162e1a44ed">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile" aria-selected="true" >Requests</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="endpoints-tab" data-bs-toggle="tab" href="#tab-endpoints" role="tab" aria-controls="tab-endpoints" aria-selected="false">Allowed Endpoints</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="areasofexpertise-tab" data-bs-toggle="tab" href="#tab-areasofexpertise" role="tab" aria-controls="tab-areasofexpertise" aria-selected="false">Attributes</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="regdetails-tab" data-bs-toggle="tab" href="#tab-regdetails" role="tab" aria-controls="tab-regdetails" aria-selected="false">Whitelisted IP</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#tab-contact" role="tab" aria-controls="tab-contact" aria-selected="false">Users</a></li>
                            </ul>
                            <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                                'label' => 'Name',
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
                                                'format' => 'raw',
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'label' => 'Status',
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
                                                'attribute' => 'created_at',
                                                'label' => 'Date created',
                                                'value' => function ($model) {
                                                    return date('d F, Y H:i:s', strtotime($model->created_at));
                                                }
                                            ],
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="tab-endpoints" role="tabpanel" aria-labelledby="endpoints-tab">
                                    <div class="row"> 
                                        <div class="col-lg-12"> 
                                            <?php if (User::isUserAllowedTo('Manage clients')) { ?>
                                                <button class="btn btn-outline-danger btn-sm px-3" type="button" data-bs-toggle="modal" data-bs-target="#endpoints">
                                                    Update endpoints
                                                </button>
                                            <?php } ?>
                                            <hr>
                                        </div>
                                        <div class="col-lg-12">&nbsp; </div>
                                        <div class="col-lg-12"> 
                                            <?php
                                            $arrayEndpoints = [];
                                            if (!empty($model->clientEndpoints)) {
                                                echo "<ol><h5>";
                                                foreach ($model->clientEndpoints as $endpoint) {
                                                    $endpointName = AvailableEndpoints::findOne(['search_key' => $endpoint['endpoint']]);
                                                    array_push($arrayEndpoints, $endpoint['endpoint']);
                                                    echo "<li>" . $endpointName->name . " - " . $endpointName->endpoint . "</li>";
                                                }
                                                echo "</h5></ol>";
                                            } else {
                                                echo '<div class="col-lg-12 py-3 text-center">'
                                                . '<span class="badge me-1 py-2 badge-soft-warning fs--1">Click add Update endpoints button above to add/update client endpoints</span>'
                                                . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-areasofexpertise" role="tabpanel" aria-labelledby="areasofexpertise-tab">
                                    <div class="row"> 
                                        <div class="col-lg-12"> 
                                            <?php if (User::isUserAllowedTo('Manage clients')) { ?>
                                                <button class="btn btn-outline-danger btn-sm px-3" type="button" data-bs-toggle="modal" data-bs-target="#areaOfExpertise">
                                                    Update attributes
                                                </button>
                                            <?php } ?>
                                            <hr>
                                        </div>
                                        <div class="col-lg-12">&nbsp; </div>
                                        <div class="col-lg-12"> 
                                            <?php
                                            $attributes = "";
                                            $array = [];
                                            if (!empty($model->clientAttributes)) {
                                                foreach ($model->clientAttributes as $attribute) {
                                                    $attributeName = AvailableAttributes::findOne(['attribute' => $attribute['attribute']]);
                                                    $attributes .= $attributeName->name . ', ';
                                                    array_push($array, $attribute['attribute']);
                                                }
                                                echo "<h5>" . $attributes . "</h5>";
                                            } else {
                                                echo '<div class="col-lg-12 py-3 text-center">'
                                                . '<span class="badge me-1 py-2 badge-soft-warning fs--1">Click add Update attributes button above to add/update attributes</span>'
                                                . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-regdetails" role="tabpanel" aria-labelledby="regdetails-tab">
                                    <?php
                                    $_model = backend\models\ClientIpWhitelist::findOne(["client" => $model->id]);
                                    if (!empty($_model)) {
                                        $ip_model = $_model;
                                        echo "<p class='fs-2'>" . $_model->ip . "</p>";
                                        if (User::isUserAllowedTo('Manage clients')) {
                                            echo '<hr><div class="text-center">
                                                     <button class="btn btn-outline-danger btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#updateIpAddress">
                                                       Update IP
                                                     </button>
                                                  </div>';
                                        }
                                    } else {
                                        $ip_model = new backend\models\ClientIpWhitelist();
                                        echo '<div class="alert alert-danger border-2  align-items-center text-center">
                                                No client IP address has been whitelisted. Client will not be able to access the services! Click the button below to whitelist client IP address.
                                              </div><div class="col-lg-12">&nbsp; </div>';
                                        if (User::isUserAllowedTo('Manage clients')) {
                                            echo ' <div class="text-center">
                                                        <a href="#" class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#updateIpAddress">
                                                            Whitelist IP
                                                        </a>
                                                    </div>';
                                        }
                                    }
                                    ?>


                                </div>
                                <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="col-lg-12"> 
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $dataProviderClientUsers,
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
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->first_name . " " . $model->other_names . " " . $model->last_name;
                                                    }
                                                ],
                                                'email:email',
                                                [
                                                    'attribute' => 'active',
                                                    'label' => 'Status',
                                                    'value' => function ($model) {
                                                        $str = "";
                                                        if ($model->active == 1) {
                                                            $str = "<span class='badge badge-soft-success badge-pill ms-2'>"
                                                                    . "<i class='fas fa-check'></i> Active</span><br>";
                                                        }
                                                        if ($model->active == 0) {
                                                            $str = "<span class='badge badge-soft-danger badge-pill ms-2'> "
                                                                    . "<i class='fas fa-times'></i> Inactive</span><br>";
                                                        }

                                                        return $str;
                                                    },
                                                    'format' => 'raw',
                                                ],
                                                [
                                                    'attribute' => 'created_at',
                                                    'label' => 'Date created',
                                                    'value' => function ($model) {
                                                        return date('d F, Y H:i:s', strtotime($model->created_at));
                                                    }
                                                ],
                                            ],
                                        ]);
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
</div>


<div class="modal fade" id="endpoints" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="endpoints" aria-hidden="true">
    <div class="modal-dialog modal-xl mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="endpointsLabel">Update allowed client API endpoints</h4>
                </div>
                <div class="p-4">
                    <div class="row">

                        <div class="col-lg-8">
                            <?php
                            $endpointModel = new ClientEndpoints();
                            if (!empty($model->clientEndpoints)) {
                                $endpointModel->endpoints = $arrayEndpoints;
                            }

                            $form2 = ActiveForm::begin(
                                            [
                                                'action' => 'update-endpoints?id=' . $model->id,
                                                'type' => ActiveForm::TYPE_VERTICAL,
                                                'formConfig' =>
                                                [
                                                    'showRequiredIndicator' => true,
                                                ]
                            ]);

                            echo $form2->field($endpointModel, 'endpoints', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'text-dark is-required',
                                    'style' => "font-size:14px;font-weight:normal;",
                                ],
                            ])->checkboxList(\yii\helpers\ArrayHelper::map(AvailableEndpoints::getAvailableEndpoints(), 'search_key', 'name'), [
                                'custom' => true,
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $checked = $checked ? 'checked' : '';
                                    return "<label class='form-check-label col-md-6' style='font-size:15px;cursor: pointer;' > "
                                    . "<input class='form-check-input' type='checkbox' {$checked} name='{$name}' value='{$value}'>&nbsp;&nbsp;{$label} </label>";
                                },
                                'separator' => false,
                                'required' => true,
                            ])->label(false);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <ol>
                                <li class="fs--1">The selected endpoints are the only endpoints the client will be allowed to access</li>
                                <li class="fs--1">Tick all required client endpoints</li>
                                <li class="fs--1">Fields marked with <span class="text-danger">*</span> are required</li>
                            </ol>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-md font-weight-bold font-size:18px;']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
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
                    <h4 class="mb-1" id="areaOfExpertiseLabel">Update client attributes</h4>
                </div>
                <div class="p-4">
                    <div class="row">

                        <div class="col-lg-8">
                            <?php
                            $attributeModel = new backend\models\ClientAttributes();
                            if (!empty($model->clientAttributes)) {
                                $attributeModel->attributes = $array;
                            }

                            $form = ActiveForm::begin(
                                            [
                                                'action' => 'update-attributes?id=' . $model->id,
                                                'type' => ActiveForm::TYPE_VERTICAL,
                                                'formConfig' =>
                                                [
                                                    'showRequiredIndicator' => true,
                                                ]
                            ]);

                            echo $form->field($attributeModel, 'attributes', [
                                'enableAjaxValidation' => true,
                                'labelOptions' => [
                                    'class' => 'text-dark is-required',
                                    'style' => "font-size:14px;font-weight:normal;",
                                ],
                            ])->checkboxList(\yii\helpers\ArrayHelper::map(AvailableAttributes::getAvailableAttributes(), 'attribute', 'name'), [
                                'custom' => true,
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $checked = $checked ? 'checked' : '';
                                    return "<label class='form-check-label col-md-3' style='font-size:15px;cursor: pointer;' > "
                                    . "<input class='form-check-input' type='checkbox' {$checked} name='{$name}' value='{$value}'>&nbsp;&nbsp;{$label} </label>";
                                },
                                'separator' => false,
                                'required' => true,
                            ])->label(false);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <ol>
                                <li class="fs--1">Tick all required client attributes</li>
                                <li class="fs--1">Fields marked with <span class="text-danger">*</span> are required</li>
                            </ol>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-md font-weight-bold font-size:18px;']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateIpAddress" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateIpAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-md mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="updateIpAddressLabel">IP address whitelisting</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <?php
                        $form1 = ActiveForm::begin(
                                        [
                                            'action' => 'whitelist-ip?id=' . $model->id,
                                            'type' => ActiveForm::TYPE_VERTICAL,
                                            'formConfig' =>
                                            [
                                                'showRequiredIndicator' => true,
                                            ]
                        ]);
                        ?>
                        <?=
                        $form1->field($ip_model, 'ip')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                'alias' => 'ip'
                            ],
                        ])->label("IP address");
                        ?>

                        <div class="col-lg-12">
                            <?= Html::submitButton('Update', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' btn-md font-weight-bold font-size:18px;']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


