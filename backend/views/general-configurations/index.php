<?php

use kartik\grid\EditableColumn;
use backend\models\User;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\popover\PopoverX;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var backend\models\ConfigurationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'General configurations';
$this->params['breadcrumbs'][] = $this->title;
$read_only = true;
$fullExportMenu = "";
?>
<div class="card mb-3">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col d-flex align-items-center">
                <div class="col-auto align-self-center">
                    <ol>
                        <li class="mb-1">
                            These configs are used by the system, hence the name cannot be modified only the value
                        </li>
                    </ol>

                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto ms-3 ps-3 " id="emails-actions">
                    <div class="btn-group btn-group-sm">
                        <?php
                        if (User::isUserAllowedTo('Manage configurations')) {
                            $read_only = false;
                            echo '<button class="' . Yii::$app->params['btnClassFalcon'] . ' btn-sm me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#submitInfo">
                              Add new config
                            </button>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body fs--1 border-top border-200 p-0" id="emails">
        <div class="row border-bottom border-200 hover-actions-trigger hover-shadow py-2 px-1 mx-0 bg-white dark__bg-dark" data-href="">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'name',
                    'filter' => false
                ],
                [
                    'options' => ['style' => 'width:350px;'],
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'attribute' => 'value',
                    'readonly' => $read_only,
                    'editableOptions' => [
                        'asPopover' => true,
                        'size' => PopoverX::SIZE_MEDIUM,
                    ],
                    'filter' => false,
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Date created',
                    'filter' => false,
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', strtotime($model->created_at));
                    }
                ],
                [
                    'attribute' => 'created_by',
                    'label' => 'Created by',
                    'filter' => false,
                    'value' => function ($model) {
                        return !empty($model->createdBy) ? $model->createdBy->first_name . " " . $model->createdBy->other_name . " " . $model->createdBy->last_name : "";
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'label' => 'Date updated',
                    'filter' => false,
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', strtotime($model->updated_at));
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'label' => 'Updated by',
                    'filter' => false,
                    'value' => function ($model) {
                        return !empty($model->updateBy) ? $model->updateBy->first_name . " " . $model->updateBy->other_name . " " . $model->updateBy->last_name : "";
                    }
                ],
                    //'updated_by',
                    //'updated_at',
            ];

            if (!empty($dataProvider) && $dataProvider->getCount() > 0) {
                $fullExportMenu = ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            "columnSelectorMenuOptions" => [
                                'class' => 'btn btn-falcon-success',
                                'style' => 'font-size: 15px;padding-left: 10px;cursor:pointer',
                            ],
                            'columnSelectorOptions' => [
                                'label' => 'Cols...',
                                'class' => Yii::$app->params['btnClassFalcon'],
                            //'title' => 'Select columns to export',
                            ],
                            'batchSize' => 500,
                            'export' => [
                                'fontAwesome' => true
                            ],
                            'exportConfig' => [
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => false,
                                ExportMenu::FORMAT_PDF => false,
                                ExportMenu::FORMAT_CSV => false,
                            ],
                            'pjaxContainerId' => 'kv-pjax-container',
                            'exportContainer' => [
                                'class' => 'btn-group mr-2'
                            ],
                            'dropdownOptions' => [
                                'label' => 'Export data',
                                'class' => Yii::$app->params['btnClassFalcon'],
                                'title' => 'Export grid data',
                                'itemsBefore' => [
                                    '<div class="dropdown-header">Export All Data</div>',
                                ],
                            ],
                            'filename' => 'generalconfigexport_' . date("dmYHis")
                ]);
            }

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'resizableColumns' => true,
                'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
                // 'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                ],
                // set a label for default menu
                'export' => false,
                'exportContainer' => [
                    'class' => 'form-select js-choice'
                ],
                // your toolbar can include the additional full export menu
                'toolbar' => [
                    '{export}',
                    $fullExportMenu,
                ]
            ]);
            ?>


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
                    <h4 class="mb-1" id="staticBackdropLabel">Add general configuration</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php
                            $model = new \backend\models\Configurations();
                            $form = ActiveForm::begin(
                                            [
                                                'action' => 'create',
                                                //'type' => ActiveForm::TYPE_FLOATING,
                                                'formConfig' =>
                                                [
                                                    'showRequiredIndicator' => true,
                                                ]
                            ]);
                            ?>
                            <?=
                            $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                                'Config name', 'id' => "name", 'required' => true,])
                            ?>
                            <?=
                            $form->field($model, 'value', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                                'Config value', 'required' => true,])
                            ?>
                            <?= Html::submitButton('Save', ['class' => 'btn ' . Yii::$app->params['btnClass'] . ' font-weight-bold font-size:18px;']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex">
                                <ol>
                                    <li class="mb-1">
                                        These configs are used by the system, hence the name cannot be modified only the value
                                    </li>
                                    <li class="mb-1">
                                        Fields marked with <span class="text-danger">*</span> are required
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<?php
$this->registerCss('.popover-x {display:none}');
?>
