
<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\models\Requests;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use backend\models\AvailableAttributes;
Use backend\models\AvailableEndpoints;
use backend\models\ClientEndpoints;
use \yii\data\ArrayDataProvider;

/** @var yii\web\View $this */
/** @var backend\models\Clients $model */
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$cache = Yii::$app->cache;
$apiKey = $cache->get("C" . $model->id);

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
                                'attribute' => 'created_at',
                                'label' => 'Created at',
                                'value' => function () use ($model) {
                                    return date('d F, Y H:i:s', strtotime($model->created_at));
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
                                <li class="nav-item"><a class="nav-link active text-uppercase" id="apikey-tab" data-bs-toggle="tab" href="#tab-apikey" role="tab" aria-controls="tab-apikey" aria-selected="true" >API secret key</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="endpoints-tab" data-bs-toggle="tab" href="#tab-endpoints" role="tab" aria-controls="tab-endpoints" aria-selected="false">Allowed Endpoints</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#tab-areasofexpertise" role="tab" aria-controls="tab-areasofexpertise" aria-selected="false">Attributes</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="regdetails-tab" data-bs-toggle="tab" href="#tab-regdetails" role="tab" aria-controls="tab-regdetails" aria-selected="false">Whitelisted IP</a></li>
                                <li class="nav-item"><a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#tab-contact" role="tab" aria-controls="tab-contact" aria-selected="false">Users</a></li>
                            </ul>
                            <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-apikey" role="tabpanel" aria-labelledby="apikey-tab">
                                    <div class="row">
                                        <div class="col-lg-12 text-center"> 

                                            <?php
                                            if (!empty($apiKey)) {
                                                echo '<div class="row"><div class="col-lg-12 text-center">'
                                                . '<p>Use below key together with the client code to access API services</p>'
                                                . ' <div class="alert alert-success border-2  align-items-center" role="alert">
                                                <p class="mb-0 flex-1">' . $apiKey . '</p>
                                            </div></div>'
                                                . ' <div class="col-lg-12">&nbsp; </div>';
                                                echo ' <div class="col-lg-12 text-center">
                                                    <a href="#" class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#updateIpAddress">
                                                        Regenerate key
                                                    </a>
                                                </div></div>';
                                            } else {
                                                echo '<div class="badge me-1 py-2 badge-soft-warning fs--1">
                                                API secret key not generated. Click generate button below to generate
                                              </div> <div class="col-lg-12">&nbsp; </div>';
                                                echo ' <div class="text-center">
                                                    <a href="#" class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#updateIpAddress">
                                                       Generate key
                                                    </a>
                                                </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-endpoints" role="tabpanel" aria-labelledby="endpoints-tab">
                                    <div class="row"> 
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
                                                . '<span class="badge me-1 py-2 badge-soft-warning fs--1">You have not been allowed to access any API endpoint. Contact system administrator</span>'
                                                . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-areasofexpertise" role="tabpanel" aria-labelledby="areasofexpertise-tab">
                                    <div class="row"> 
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
                                                . '<span class="badge me-1 py-2 badge-soft-warning fs--1">You have no attribute mapping yet. Conatct system administrator</span>'
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
                                    } else {
                                        $ip_model = new backend\models\ClientIpWhitelist();
                                        echo '<div class="text-center"><p class="badge me-1 py-2 badge-soft-danger fs--1 ">
                                                Your IP address has not been whitelisted. You will not be able to access the services. 
                                                <br>Contact the system administrator.
                                              </p></div>';
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



<div class="modal fade" id="updateIpAddress" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateIpAddressLabel" aria-hidden="true">
    <div class="modal-dialog modal-md mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="updateIpAddressLabel">Confirm API key generation</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">
                            Click 'Confirm' button below to generate a new API Key.
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">

                    <button type="button" class="btn btn-falcon-danger btn-sm" data-bs-dismiss="modal">
                        <span class="fas fa-times-circle me-1" data-fa-transform="shrink-3"></span> Cancel
                    </button>
                    <?=
                    Html::a('<span class="fas fa-spinner me-1" data-fa-transform="shrink-3"></span> Confirm', ['home/generate-key'], ['data' => ['method' => 'POST'], 'id' => 'logout',
                        'class' => 'btn btn-success btn-sm'])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>



