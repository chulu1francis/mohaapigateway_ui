<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\models\Clients;
use yii\helpers\Url;
use backend\models\Requests;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$count = 0;
$clients = Clients::find()->count();
$requests = Requests::find()
        ->select(['amount'])
        ->where(['status' => 200])
        ->andWhere(['date(created_at)' => date("Y-m-d")])
        ->count();
$todaysRequestAmount = Requests::find()
        ->select(['amount'])
        ->where(['status' => 200])
        ->andWhere(['date(created_at)' => date("Y-m-d")])
        ->sum('amount');

$thisMonthRequestAmount = Requests::find()
        ->select(['amount'])
        ->where(['status' => 200])
        ->andWhere(['EXTRACT(MONTH FROM created_at)' => date("m")])
        //->andWhere(['MONTH(created_at)' => date("m")])
        ->sum('amount');

$month = date("F");

$months = [];
?>

<!--<div class="card h-lg-100 overflow-hidden">
    <div class="card-header bg-light">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0">Your tasks</h6>
            </div>
        </div>
    </div>
    <div class="card-body fs-0 border-top border-200 p-0">
<?php //if ($count == 0) {   ?>
            <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                <div class="col ps-card py-1 position-static">
                    <h6 class="text-700 mb-0">
                        You have no pending tasks to perform!
                    </h6>
                </div>
            </div>
<?php //}   ?>
    </div>
</div>-->

<div class="row py-2">
    <div class="col-sm-3">
        <div class="card overflow-hidden" style="min-width: 12rem">

            <div class="card-body position-relative">
                <h6>Total Clients</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":<?= $clients ?>,"decimalPlaces":0,"prefix":""}'>0</div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= Url::to("@web/clients/index") ?>">See all
                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="card-body position-relative">
                <h6>Todays requests</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":<?= $requests ?>,"decimalPlaces":0,"prefix":""}'>0</div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= Url::to("@web/requests/index") ?>">All requests
                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="card-body position-relative">
                <h6>Todays revenue</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success" data-countup='{"endValue":<?= $todaysRequestAmount ?>,"decimalPlaces":2,"prefix":"ZMW "}'>0</div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= Url::to("@web/requests/index") ?>">All requests
                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="card-body position-relative">
                <h6><?= $month ?> revenue</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-primary" data-countup='{"endValue":<?= $thisMonthRequestAmount ?>,"decimalPlaces":2,"prefix":"ZMW "}'>0</div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= Url::to("@web/requests/index") ?>">All requests
                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row py-2">
    <div class="col-sm-12">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="card-body position-relative">

                <?=
                \dosamigos\highcharts\HighCharts::widget([
                    'clientOptions' => [
                        'chart' => [
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                            'type' => 'column'
                        ],
                        'legend' => [
                            'enabled' => true
                        ],
                        'plotOptions' => [
                            'column' => [
                                //  'allowPointSelect' => true,
                                //'colorByPoint' => true,
                                'cursor' => 'pointer',
                                'dataLabels' => [
                                    'enabled' => true,
                                    'style' => [
                                        'fontSize' => '10px'
                                    ],
                                ],
                            ]
                        ],
                        'title' => [
                            'text' => 'Last 12 months requests vs revenue',
                            'style' => [
                                'fontSize' => '14px',
                                'font-weight' => 'bold'
                            ],
                        ],
                        'xAxis' => [
                            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                            'style' => [
                                'fontSize' => '11px',
                                'font-weight' => 'bold'
                            ],
                            'crosshair' => true,
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Totals'
                            ]
                        ],
                        'series' => [
                            [
                                'name' => 'Requests',
                                'data' =>
                                [
                                    $Jan,
                                    $feb,
                                    $mar,
                                    $apr,
                                    $may,
                                    $june,
                                    $july,
                                    $aug,
                                    $sep,
                                    $oct,
                                    $nov,
                                    $dec,
                                ]
                            ],
                            [
                                'name' => 'Revenue ZMW',
                                'color' => 'green',
                                'data' =>
                                [
                                    round($JanRevenue, 2),
                                    round($febRevenue, 2),
                                    round($marRevenue, 2),
                                    round($aprRevenue, 2),
                                    round($mayRevenue, 2),
                                    round($juneRevenue, 2),
                                    round($julyRevenue, 2),
                                    round($augRevenue, 2),
                                    round($sepRevenue, 2),
                                    round($octRevenue, 2),
                                    round($novRevenue, 2),
                                    round($decRevenue, 2)
                                ]
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>




