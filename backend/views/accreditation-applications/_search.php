<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AccreditationApplicationsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="accreditation-applications-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'organisation') ?>

    <?= $form->field($model, 'currency') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'income') ?>

    <?php // echo $form->field($model, 'expenditure') ?>

    <?php // echo $form->field($model, 'letter') ?>

    <?php // echo $form->field($model, 'registration_or_acknowledgement_certificate') ?>

    <?php // echo $form->field($model, 'certified_articles_of_association') ?>

    <?php // echo $form->field($model, 'bylaws') ?>

    <?php // echo $form->field($model, 'statutes_or_constitution_detailing_the_mandate') ?>

    <?php // echo $form->field($model, 'scope_and_governing_structure_or_organisational_profile') ?>

    <?php // echo $form->field($model, 'annual_income_and_expenditure_statement') ?>

    <?php // echo $form->field($model, 'names_of_all_donors_and_other_funding_sources_last_two_years') ?>

    <?php // echo $form->field($model, 'evidence_of_competency_in_thematic_areas') ?>

    <?php // echo $form->field($model, 'other_relevant_documents') ?>

    <?php // echo $form->field($model, 'compliance_with_au_data_policy') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
