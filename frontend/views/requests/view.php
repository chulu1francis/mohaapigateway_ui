<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Requests $model */
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="card mb-3">

    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Client',
                        'attribute' => 'client',
                        'format' => 'raw',
                       'format' => 'raw',
                        'value' => function() use ($model) {
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
                        'value' => function() use ($model) {
                            return "ZMW" . $model->amount;
                        },
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value' => function() use ($model) {
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
                      'value' => function() use ($model) {
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
                        'value' => function () use ($model) {
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
                             'proof_of_payment',
                ],
            ])
            ?>
        </div>
    </div>
</div>
