<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$count = 0;
?>

<div class="row g-3 mb-3">
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 ecommerce-card-min-width">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2 d-flex align-items-center">Total Student IDs
                </h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-4">
                            0
                        </p><span class="badge badge-soft-secondary rounded-pill fs--2">
                            100%</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2">Collected IDs</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row justify-content-between">
                    <div class="col-auto align-self-end">
                        <div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">
                            90
                        </div>
                        <span class="badge rounded-pill fs--2 bg-200 text-primary">
                            <span class="fas fa-caret-up me-1"></span>
                            10%
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2">Not Collected IDs</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row justify-content-between">
                    <div class="col-auto align-self-end">
                        <div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">
                            20
                        </div><span class="badge rounded-pill fs--2 bg-200 text-danger">
                            <span class="fas fa-caret-up me-1"></span>
                            10%
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100">
            <div class="card-header pb-0">
                <h6 class="mb-0 mt-2">Published documents</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-end">
                <div class="row justify-content-between">
                    <div class="col-auto align-self-end">
                        <div class="fs-4 fw-normal font-sans-serif text-700 lh-1 mb-1">
                            10
                        </div><span class="badge rounded-pill fs--2 bg-200 text-success">
                            <span class="fas fa-caret-up me-1"></span>
                            5%
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 pe-lg-2 mb-3">
        <div class="card h-lg-100 overflow-hidden">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0">Your tasks</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
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




