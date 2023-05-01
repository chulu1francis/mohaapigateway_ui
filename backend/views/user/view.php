<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use backend\models\User;

/** @var yii\web\View $this */
/** @var backend\models\User $model */
$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header position-relative min-vh-25 mb-7">
                <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(<?= Url::to('@web/img/bg.jpg') ?>);">
                </div>
                <!--/.bg-holder-->

                <div class="avatar avatar-5xl avatar-profile">
                    <?php
                    if (!empty($model->image)) {
                        echo Html::img('@web/uploads/' . $model->image, ['class' => 'rounded-circle img-thumbnail shadow-sm']);
                    } else {
                        echo Html::img('@web/img/icon.png', ['class' => 'rounded-circle img-thumbnail shadow-sm']);
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <h4 class="mb-1"> <?= $model->getFullName() ?>
                            <?php
                            if ($model->active == User::STATUS_ACTIVE) {
                                echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="Active">
                            <small class="fa fa-check-circle text-success" data-fa-transform="shrink-4 down-2"></small>
                        </span>';
                            } else {
                                echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="Inactive">
                            <small class="fa fa-times-circle text-danger" data-fa-transform="shrink-4 down-2"></small>
                        </span>';
                            }
                            ?>

                        </h4>
                        <h5 class="fs-0 fw-normal"><?= $model->group0->name ?></h5>
                        <p class="text-500">
                            <?= $model->email ?><br>
                            <?= $model->phone ?>
                        </p>
                        <?php
                        if (User::isUserAllowedTo('Manage users')) {
                            echo Html::a('Update', ['update', 'id' => $model->id],
                                    [
                                        'title' => 'Update user',
                                        'data-bs-toggle' => 'tooltip',
                                        'data-bs-placement' => 'top',
                                        'class' => 'btn '.Yii::$app->params['btnClassFalcon'].' btn-sm px-3'
                            ]);
                        }
                        ?>
                        <button class="btn btn-falcon-success btn-sm btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#updateLogo">Update profile image</button>
                        <div class="border-bottom border-dashed my-4 d-lg-none"></div>
                    </div>

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
                    <h4 class="mb-1" id="updateLogoLabel">Update user profile</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <?php
                        $form = ActiveForm::begin(
                                        [
                                            'action' => 'update-image?id=' . $model->id,
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'image', [
                            'labelOptions' => [
                                // 'class' => 'is-required',
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
                        ])->label("User profile")
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
