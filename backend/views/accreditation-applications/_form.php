<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplications $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="accreditation-applications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organisation')->textInput() ?>

    <?= $form->field($model, 'currency')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'income')->textInput() ?>

    <?= $form->field($model, 'expenditure')->textInput() ?>

    <?= $form->field($model, 'letter')->textInput() ?>

    <?= $form->field($model, 'registration_or_acknowledgement_certificate')->textInput() ?>

    <?= $form->field($model, 'certified_articles_of_association')->textInput() ?>

    <?= $form->field($model, 'bylaws')->textInput() ?>

    <?= $form->field($model, 'statutes_or_constitution_detailing_the_mandate')->textInput() ?>

    <?= $form->field($model, 'scope_and_governing_structure_or_organisational_profile')->textInput() ?>

    <?= $form->field($model, 'annual_income_and_expenditure_statement')->textInput() ?>

    <?= $form->field($model, 'names_of_all_donors_and_other_funding_sources_last_two_years')->textInput() ?>

    <?= $form->field($model, 'evidence_of_competency_in_thematic_areas')->textInput() ?>

    <?= $form->field($model, 'other_relevant_documents')->textInput() ?>

    <?= $form->field($model, 'compliance_with_au_data_policy')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
