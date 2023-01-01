<?php

namespace frontend\controllers;

use backend\models\AccreditationApplications;
use backend\models\AccreditationApplicationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;
use Yii;
use yii\web\UploadedFile;
use backend\models\AcreditationApplicationApprovals;

/**
 * AccreditationApplicationsController implements the CRUD actions for AccreditationApplications model.
 */
class AccreditationApplicationsController extends Controller {
    /**
     * @inheritDoc
     */

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['consultative', 'create', 'view', 'update', 'national',
                            'view-national', 'create-national', 'update-national', 'download', 'submit-application'],
                        'rules' => [
                            [
                                'actions' => ['consultative', 'create', 'view', 'update', 'national',
                                    'view-national', 'create-national', 'update-national', 'download', 'submit-application'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    /**
     * Lists all Consultative AccreditationApplications models.
     *
     * @return string
     */
    public function actionConsultative() {
        $searchModel = new AccreditationApplicationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andFilterWhere(['type' => "Consultative", "organisation" => Yii::$app->user->id]);

        $dataProvider->pagination = ['pageSize' => 15];
        $dataProvider->setSort([
            'attributes' => [
                'created_at' => [
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC
                ],
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all National AccreditationApplications models.
     *
     * @return string
     */
    public function actionNational() {
        $searchModel = new AccreditationApplicationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andFilterWhere(['type' => "National", "organisation" => Yii::$app->user->id]);

        $dataProvider->pagination = ['pageSize' => 15];
        $dataProvider->setSort([
            'attributes' => [
                'created_at' => [
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC
                ],
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ]);

        return $this->render('index-national', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccreditationApplications model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionViewNational($id) {
        return $this->render('view-national', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionSubmitApplication($id, $type) {
        $model = $this->findModel($id);
        $model->status = AccreditationApplications::SUBMITTED;
        if ($model->save(false)) {
            //Lets raise and approval ticket so that the approval process can start
            $approvalModel = new AcreditationApplicationApprovals();
            $approvalModel->application = $id;
            $approvalModel->remarks_accreditation_officer = "Not set";
            $approvalModel->remarks_head_of_programs = "Not set";
            $approvalModel->status_accreditation_officer = 0;
            $approvalModel->status_head_of_programs = 0;
            $approvalModel->application = $id;
            if ($approvalModel->save(false)) {
                Yii::$app->session->setFlash('success', "Application has been submitted pending accreditation officer review");
            } else {
                Yii::$app->session->setFlash('error', "Application could not be submitted. Please try again");
            }

            if ($type == 0) {
                return $this->redirect(['consultative']);
            } else {
                return $this->redirect(['national']);
            }
        } else {
            Yii::$app->session->setFlash('error', "Application could not be submitted. Please try again");
            if ($type == 0) {
                return $this->redirect(['consultative']);
            } else {
                return $this->redirect(['national']);
            }
        }
    }

    /**
     * Creates a new AccreditationApplications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new AccreditationApplications();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                //Application letter
                $letter = UploadedFile::getInstance($model, 'letter');
                $model->letter = Yii::$app->security->generateRandomString() . "." . $letter->extension;
                $letter->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->letter);

                //Registration or ack certificate
                $registration_or_acknowledgement_certificate = UploadedFile::getInstance($model, 'registration_or_acknowledgement_certificate');
                $model->registration_or_acknowledgement_certificate = Yii::$app->security->generateRandomString() . "." . $registration_or_acknowledgement_certificate->extension;
                $registration_or_acknowledgement_certificate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->registration_or_acknowledgement_certificate);

                //Articles of association
                $certified_articles_of_association = UploadedFile::getInstance($model, 'certified_articles_of_association');
                $model->certified_articles_of_association = Yii::$app->security->generateRandomString() . "." . $certified_articles_of_association->extension;
                $certified_articles_of_association->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->certified_articles_of_association);

                //By laws
                $bylaws = UploadedFile::getInstance($model, 'bylaws');
                $model->bylaws = Yii::$app->security->generateRandomString() . "." . $bylaws->extension;
                $bylaws->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->bylaws);

                //Statutes or constitution detailing mandate
                $statutes_or_constitution_detailing_the_mandate = UploadedFile::getInstance($model, 'statutes_or_constitution_detailing_the_mandate');
                $model->statutes_or_constitution_detailing_the_mandate = Yii::$app->security->generateRandomString() . "." . $statutes_or_constitution_detailing_the_mandate->extension;
                $statutes_or_constitution_detailing_the_mandate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->statutes_or_constitution_detailing_the_mandate);

                //Scope and governing structure or organisation profile
                $scope_and_governing_structure_or_organisational_profile = UploadedFile::getInstance($model, 'scope_and_governing_structure_or_organisational_profile');
                $model->scope_and_governing_structure_or_organisational_profile = Yii::$app->security->generateRandomString() . "." . $scope_and_governing_structure_or_organisational_profile->extension;
                $scope_and_governing_structure_or_organisational_profile->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->scope_and_governing_structure_or_organisational_profile);

                //Annual income statement
                $annual_income_and_expenditure_statement = UploadedFile::getInstance($model, 'annual_income_and_expenditure_statement');
                $model->annual_income_and_expenditure_statement = Yii::$app->security->generateRandomString() . "." . $annual_income_and_expenditure_statement->extension;
                $annual_income_and_expenditure_statement->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->annual_income_and_expenditure_statement);

                //Names of all donors and other funding
                $names_of_all_donors_and_other_funding_sources_last_two_years = UploadedFile::getInstance($model, 'names_of_all_donors_and_other_funding_sources_last_two_years');
                $model->names_of_all_donors_and_other_funding_sources_last_two_years = Yii::$app->security->generateRandomString() . "." . $names_of_all_donors_and_other_funding_sources_last_two_years->extension;
                $names_of_all_donors_and_other_funding_sources_last_two_years->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->names_of_all_donors_and_other_funding_sources_last_two_years);

                //Evidence of compentency in thematic areas
                $evidence_of_competency_in_thematic_areas = UploadedFile::getInstance($model, 'evidence_of_competency_in_thematic_areas');
                $model->evidence_of_competency_in_thematic_areas = Yii::$app->security->generateRandomString() . "." . $evidence_of_competency_in_thematic_areas->extension;
                $evidence_of_competency_in_thematic_areas->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->evidence_of_competency_in_thematic_areas);

                //Other relevant documents
                $other_relevant_documents = UploadedFile::getInstance($model, 'other_relevant_documents');
                $model->other_relevant_documents = Yii::$app->security->generateRandomString() . "." . $other_relevant_documents->extension;
                $other_relevant_documents->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->other_relevant_documents);

                $model->compliance_with_au_data_policy = 1;
                $model->organisation = Yii::$app->user->id;
                $model->type = "Consultative";
                $model->status = AccreditationApplications::NOT_SUBMITTED;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "Consultative status application has been successfull saved");
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while saving application.Please try again.Error::" . $message);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionCreateNational() {
        $model = new AccreditationApplications();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                //Application letter
                $letter = UploadedFile::getInstance($model, 'letter');
                $model->letter = Yii::$app->security->generateRandomString() . "." . $letter->extension;
                $letter->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->letter);

                //Registration or ack certificate
                $registration_or_acknowledgement_certificate = UploadedFile::getInstance($model, 'registration_or_acknowledgement_certificate');
                $model->registration_or_acknowledgement_certificate = Yii::$app->security->generateRandomString() . "." . $registration_or_acknowledgement_certificate->extension;
                $registration_or_acknowledgement_certificate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->registration_or_acknowledgement_certificate);

                //Articles of association
                $certified_articles_of_association = UploadedFile::getInstance($model, 'certified_articles_of_association');
                $model->certified_articles_of_association = Yii::$app->security->generateRandomString() . "." . $certified_articles_of_association->extension;
                $certified_articles_of_association->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->certified_articles_of_association);

                //By laws
                $bylaws = UploadedFile::getInstance($model, 'bylaws');
                $model->bylaws = Yii::$app->security->generateRandomString() . "." . $bylaws->extension;
                $bylaws->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->bylaws);

                //Statutes or constitution detailing mandate
                $statutes_or_constitution_detailing_the_mandate = UploadedFile::getInstance($model, 'statutes_or_constitution_detailing_the_mandate');
                $model->statutes_or_constitution_detailing_the_mandate = Yii::$app->security->generateRandomString() . "." . $statutes_or_constitution_detailing_the_mandate->extension;
                $statutes_or_constitution_detailing_the_mandate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->statutes_or_constitution_detailing_the_mandate);

                //Scope and governing structure or organisation profile
                $scope_and_governing_structure_or_organisational_profile = UploadedFile::getInstance($model, 'scope_and_governing_structure_or_organisational_profile');
                $model->scope_and_governing_structure_or_organisational_profile = Yii::$app->security->generateRandomString() . "." . $scope_and_governing_structure_or_organisational_profile->extension;
                $scope_and_governing_structure_or_organisational_profile->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->scope_and_governing_structure_or_organisational_profile);

                //Annual income statement
                $annual_income_and_expenditure_statement = UploadedFile::getInstance($model, 'annual_income_and_expenditure_statement');
                $model->annual_income_and_expenditure_statement = Yii::$app->security->generateRandomString() . "." . $annual_income_and_expenditure_statement->extension;
                $annual_income_and_expenditure_statement->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->annual_income_and_expenditure_statement);

                //Names of all donors and other funding
                $names_of_all_donors_and_other_funding_sources_last_two_years = UploadedFile::getInstance($model, 'names_of_all_donors_and_other_funding_sources_last_two_years');
                $model->names_of_all_donors_and_other_funding_sources_last_two_years = Yii::$app->security->generateRandomString() . "." . $names_of_all_donors_and_other_funding_sources_last_two_years->extension;
                $names_of_all_donors_and_other_funding_sources_last_two_years->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->names_of_all_donors_and_other_funding_sources_last_two_years);

                //Evidence of compentency in thematic areas
                $evidence_of_competency_in_thematic_areas = UploadedFile::getInstance($model, 'evidence_of_competency_in_thematic_areas');
                $model->evidence_of_competency_in_thematic_areas = Yii::$app->security->generateRandomString() . "." . $evidence_of_competency_in_thematic_areas->extension;
                $evidence_of_competency_in_thematic_areas->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->evidence_of_competency_in_thematic_areas);

                //Other relevant documents
                $other_relevant_documents = UploadedFile::getInstance($model, 'other_relevant_documents');
                $model->other_relevant_documents = Yii::$app->security->generateRandomString() . "." . $other_relevant_documents->extension;
                $other_relevant_documents->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->other_relevant_documents);

                $model->compliance_with_au_data_policy = 1;
                $model->organisation = Yii::$app->user->id;
                $model->type = "National";
                $model->status = AccreditationApplications::NOT_SUBMITTED;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', "National status application has been successfull saved");
                    return $this->redirect(['view-national', 'id' => $model->id]);
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while saving application.Please try again.Error::" . $message);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-national', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AccreditationApplications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModelNotSubmitted($id);
        if (!empty($model)) {
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            $oldletter = $model->letter;
            $oldregistration_or_acknowledgement_certificate = $model->registration_or_acknowledgement_certificate;
            $oldcertified_articles_of_association = $model->certified_articles_of_association;
            $oldbylaws = $model->bylaws;
            $oldstatutes_or_constitution_detailing_the_mandate = $model->statutes_or_constitution_detailing_the_mandate;
            $oldscope_and_governing_structure_or_organisational_profile = $model->scope_and_governing_structure_or_organisational_profile;
            $oldannual_income_and_expenditure_statement = $model->annual_income_and_expenditure_statement;
            $oldnames_of_all_donors_and_other_funding_sources_last_two_years = $model->names_of_all_donors_and_other_funding_sources_last_two_years;
            $oldevidence_of_competency_in_thematic_areas = $model->evidence_of_competency_in_thematic_areas;
            $oldother_relevant_documents = $model->other_relevant_documents;

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    //Application letter
                    $letter = UploadedFile::getInstance($model, 'letter');
                    $model->letter = Yii::$app->security->generateRandomString() . "." . $letter->extension;
                    $letter->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->letter);

                    //Registration or ack certificate
                    $registration_or_acknowledgement_certificate = UploadedFile::getInstance($model, 'registration_or_acknowledgement_certificate');
                    $model->registration_or_acknowledgement_certificate = Yii::$app->security->generateRandomString() . "." . $registration_or_acknowledgement_certificate->extension;
                    $registration_or_acknowledgement_certificate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->registration_or_acknowledgement_certificate);

                    //Articles of association
                    $certified_articles_of_association = UploadedFile::getInstance($model, 'certified_articles_of_association');
                    $model->certified_articles_of_association = Yii::$app->security->generateRandomString() . "." . $certified_articles_of_association->extension;
                    $certified_articles_of_association->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->certified_articles_of_association);

                    //By laws
                    $bylaws = UploadedFile::getInstance($model, 'bylaws');
                    $model->bylaws = Yii::$app->security->generateRandomString() . "." . $bylaws->extension;
                    $bylaws->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->bylaws);

                    //Statutes or constitution detailing mandate
                    $statutes_or_constitution_detailing_the_mandate = UploadedFile::getInstance($model, 'statutes_or_constitution_detailing_the_mandate');
                    $model->statutes_or_constitution_detailing_the_mandate = Yii::$app->security->generateRandomString() . "." . $statutes_or_constitution_detailing_the_mandate->extension;
                    $statutes_or_constitution_detailing_the_mandate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->statutes_or_constitution_detailing_the_mandate);

                    //Scope and governing structure or organisation profile
                    $scope_and_governing_structure_or_organisational_profile = UploadedFile::getInstance($model, 'scope_and_governing_structure_or_organisational_profile');
                    $model->scope_and_governing_structure_or_organisational_profile = Yii::$app->security->generateRandomString() . "." . $scope_and_governing_structure_or_organisational_profile->extension;
                    $scope_and_governing_structure_or_organisational_profile->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->scope_and_governing_structure_or_organisational_profile);

                    //Annual income statement
                    $annual_income_and_expenditure_statement = UploadedFile::getInstance($model, 'annual_income_and_expenditure_statement');
                    $model->annual_income_and_expenditure_statement = Yii::$app->security->generateRandomString() . "." . $annual_income_and_expenditure_statement->extension;
                    $annual_income_and_expenditure_statement->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->annual_income_and_expenditure_statement);

                    //Names of all donors and other funding
                    $names_of_all_donors_and_other_funding_sources_last_two_years = UploadedFile::getInstance($model, 'names_of_all_donors_and_other_funding_sources_last_two_years');
                    $model->names_of_all_donors_and_other_funding_sources_last_two_years = Yii::$app->security->generateRandomString() . "." . $names_of_all_donors_and_other_funding_sources_last_two_years->extension;
                    $names_of_all_donors_and_other_funding_sources_last_two_years->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->names_of_all_donors_and_other_funding_sources_last_two_years);

                    //Evidence of compentency in thematic areas
                    $evidence_of_competency_in_thematic_areas = UploadedFile::getInstance($model, 'evidence_of_competency_in_thematic_areas');
                    $model->evidence_of_competency_in_thematic_areas = Yii::$app->security->generateRandomString() . "." . $evidence_of_competency_in_thematic_areas->extension;
                    $evidence_of_competency_in_thematic_areas->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->evidence_of_competency_in_thematic_areas);

                    //Other relevant documents
                    $other_relevant_documents = UploadedFile::getInstance($model, 'other_relevant_documents');
                    $model->other_relevant_documents = Yii::$app->security->generateRandomString() . "." . $other_relevant_documents->extension;
                    $other_relevant_documents->saveAs(Yii::getAlias('@frontend') . '/web/uploads/consultativefiles/' . $model->other_relevant_documents);

                    $model->compliance_with_au_data_policy = 1;
                    $model->organisation = Yii::$app->user->id;
                    $model->type = "Consultative";
                    $model->status = AccreditationApplications::NOT_SUBMITTED;

                    if ($model->save()) {
                        //Lets delete old files
                        $this->deleteFile('consultativefiles/' . $oldletter);
                        $this->deleteFile('consultativefiles/' . $oldregistration_or_acknowledgement_certificate);
                        $this->deleteFile('consultativefiles/' . $oldcertified_articles_of_association);
                        $this->deleteFile('consultativefiles/' . $oldstatutes_or_constitution_detailing_the_mandate);
                        $this->deleteFile('consultativefiles/' . $oldscope_and_governing_structure_or_organisational_profile);
                        $this->deleteFile('consultativefiles/' . $oldannual_income_and_expenditure_statement);
                        $this->deleteFile('consultativefiles/' . $oldnames_of_all_donors_and_other_funding_sources_last_two_years);
                        $this->deleteFile('consultativefiles/' . $oldevidence_of_competency_in_thematic_areas);
                        $this->deleteFile('consultativefiles/' . $oldother_relevant_documents);
                        $this->deleteFile('consultativefiles/' . $oldbylaws);
                        Yii::$app->session->setFlash('success', "Consultative status application has been successfull updated");
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('error', "Error occured while updating application.Please try again.Error::" . $message);
                    }
                }
            }

            return $this->render('update', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', "You are not allowed to update this consultative application");
            return $this->redirect(['index', 'id' => $model->id]);
        }
    }

    public function actionUpdateNational($id) {
        $model = $this->findModelNotSubmitted($id);
        if (!empty($model)) {
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            $oldletter = $model->letter;
            $oldregistration_or_acknowledgement_certificate = $model->registration_or_acknowledgement_certificate;
            $oldcertified_articles_of_association = $model->certified_articles_of_association;
            $oldbylaws = $model->bylaws;
            $oldstatutes_or_constitution_detailing_the_mandate = $model->statutes_or_constitution_detailing_the_mandate;
            $oldscope_and_governing_structure_or_organisational_profile = $model->scope_and_governing_structure_or_organisational_profile;
            $oldannual_income_and_expenditure_statement = $model->annual_income_and_expenditure_statement;
            $oldnames_of_all_donors_and_other_funding_sources_last_two_years = $model->names_of_all_donors_and_other_funding_sources_last_two_years;
            $oldevidence_of_competency_in_thematic_areas = $model->evidence_of_competency_in_thematic_areas;
            $oldother_relevant_documents = $model->other_relevant_documents;

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    //Application letter
                    $letter = UploadedFile::getInstance($model, 'letter');
                    $model->letter = Yii::$app->security->generateRandomString() . "." . $letter->extension;
                    $letter->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->letter);

                    //Registration or ack certificate
                    $registration_or_acknowledgement_certificate = UploadedFile::getInstance($model, 'registration_or_acknowledgement_certificate');
                    $model->registration_or_acknowledgement_certificate = Yii::$app->security->generateRandomString() . "." . $registration_or_acknowledgement_certificate->extension;
                    $registration_or_acknowledgement_certificate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->registration_or_acknowledgement_certificate);

                    //Articles of association
                    $certified_articles_of_association = UploadedFile::getInstance($model, 'certified_articles_of_association');
                    $model->certified_articles_of_association = Yii::$app->security->generateRandomString() . "." . $certified_articles_of_association->extension;
                    $certified_articles_of_association->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->certified_articles_of_association);

                    //By laws
                    $bylaws = UploadedFile::getInstance($model, 'bylaws');
                    $model->bylaws = Yii::$app->security->generateRandomString() . "." . $bylaws->extension;
                    $bylaws->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->bylaws);

                    //Statutes or constitution detailing mandate
                    $statutes_or_constitution_detailing_the_mandate = UploadedFile::getInstance($model, 'statutes_or_constitution_detailing_the_mandate');
                    $model->statutes_or_constitution_detailing_the_mandate = Yii::$app->security->generateRandomString() . "." . $statutes_or_constitution_detailing_the_mandate->extension;
                    $statutes_or_constitution_detailing_the_mandate->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->statutes_or_constitution_detailing_the_mandate);

                    //Scope and governing structure or organisation profile
                    $scope_and_governing_structure_or_organisational_profile = UploadedFile::getInstance($model, 'scope_and_governing_structure_or_organisational_profile');
                    $model->scope_and_governing_structure_or_organisational_profile = Yii::$app->security->generateRandomString() . "." . $scope_and_governing_structure_or_organisational_profile->extension;
                    $scope_and_governing_structure_or_organisational_profile->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->scope_and_governing_structure_or_organisational_profile);

                    //Annual income statement
                    $annual_income_and_expenditure_statement = UploadedFile::getInstance($model, 'annual_income_and_expenditure_statement');
                    $model->annual_income_and_expenditure_statement = Yii::$app->security->generateRandomString() . "." . $annual_income_and_expenditure_statement->extension;
                    $annual_income_and_expenditure_statement->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->annual_income_and_expenditure_statement);

                    //Names of all donors and other funding
                    $names_of_all_donors_and_other_funding_sources_last_two_years = UploadedFile::getInstance($model, 'names_of_all_donors_and_other_funding_sources_last_two_years');
                    $model->names_of_all_donors_and_other_funding_sources_last_two_years = Yii::$app->security->generateRandomString() . "." . $names_of_all_donors_and_other_funding_sources_last_two_years->extension;
                    $names_of_all_donors_and_other_funding_sources_last_two_years->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->names_of_all_donors_and_other_funding_sources_last_two_years);

                    //Evidence of compentency in thematic areas
                    $evidence_of_competency_in_thematic_areas = UploadedFile::getInstance($model, 'evidence_of_competency_in_thematic_areas');
                    $model->evidence_of_competency_in_thematic_areas = Yii::$app->security->generateRandomString() . "." . $evidence_of_competency_in_thematic_areas->extension;
                    $evidence_of_competency_in_thematic_areas->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->evidence_of_competency_in_thematic_areas);

                    //Other relevant documents
                    $other_relevant_documents = UploadedFile::getInstance($model, 'other_relevant_documents');
                    $model->other_relevant_documents = Yii::$app->security->generateRandomString() . "." . $other_relevant_documents->extension;
                    $other_relevant_documents->saveAs(Yii::getAlias('@frontend') . '/web/uploads/nationalfiles/' . $model->other_relevant_documents);

                    $model->compliance_with_au_data_policy = 1;
                    $model->organisation = Yii::$app->user->id;
                    $model->type = "National";
                    $model->status = AccreditationApplications::NOT_SUBMITTED;

                    if ($model->save()) {
                        //Lets delete old files
                        $this->deleteFile("nationalfiles/" . $oldletter);
                        $this->deleteFile("nationalfiles/" . $oldregistration_or_acknowledgement_certificate);
                        $this->deleteFile("nationalfiles/" . $oldcertified_articles_of_association);
                        $this->deleteFile("nationalfiles/" . $oldstatutes_or_constitution_detailing_the_mandate);
                        $this->deleteFile("nationalfiles/" . $oldscope_and_governing_structure_or_organisational_profile);
                        $this->deleteFile("nationalfiles/" . $oldannual_income_and_expenditure_statement);
                        $this->deleteFile("nationalfiles/" . $oldnames_of_all_donors_and_other_funding_sources_last_two_years);
                        $this->deleteFile("nationalfiles/" . $oldevidence_of_competency_in_thematic_areas);
                        $this->deleteFile("nationalfiles/" . $oldother_relevant_documents);
                        $this->deleteFile("nationalfiles/" . $oldbylaws);

                        Yii::$app->session->setFlash('success', "National status application has been successfull updated");
                        return $this->redirect(['view-national', 'id' => $model->id]);
                    } else {
                        $message = '';
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        Yii::$app->session->setFlash('error', "Error occured while updating application.Please try again.Error::" . $message);
                    }
                }
            }

            return $this->render('update-national', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', "You are not allowed to update this consultative application");
            return $this->redirect(['index', 'id' => $model->id]);
        }
    }

    private static function deleteFile($file) {
        if (!empty($file)) {
            if (file_exists(Yii::getAlias('@frontend') . '/web/uploads/' . $file)) {
                unlink(Yii::getAlias('@frontend') . '/web/uploads/' . $file);
            }
        }
    }

    public function actionDownload($file, $filename, $folder = "") {
        // This will need to be the path relative to the root of your app.
        $filePath = Yii::getAlias('@frontend') . '/web/uploads/' . $folder;
        // Might need to change '@app' for another alias
        $completePath = $filePath . '/' . $file;

        return Yii::$app->response->sendFile($completePath, $filename);
    }

    /**
     * Deletes an existing AccreditationApplications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AccreditationApplications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AccreditationApplications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AccreditationApplications::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelNotSubmitted($id) {

        if (($model = AccreditationApplications::findOne(['id' => $id, "status" => AccreditationApplications::NOT_SUBMITTED])) !== null) {
            return $model;
        } else {
            return "";
        }
    }

}
