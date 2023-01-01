<?php

namespace backend\controllers;

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
use backend\models\User;
use backend\models\ReviewModel;
use backend\models\ApprovalModel;
use kartik\mpdf\Pdf;

/**
 * AccreditationApplicationsController implements the CRUD actions for AccreditationApplications model.
 */
class AccreditationApplicationsController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['consultative', 'create', 'view', 'review', 'approve', 'review-national', 'approve-national', 'national',
                            'view-national', 'download', 'download-duediligence','print-certificate'],
                        'rules' => [
                            [
                                'actions' => ['consultative', 'create', 'view', 'review', 'approve', 'review-national', 'approve-national', 'national',
                                    'view-national', 'download', 'download-duediligence','print-certificate'],
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
        if (User::isUserAllowedTo("View applications") ||
                User::isUserAllowedTo("Review consultative accreditations") ||
                User::isUserAllowedTo("Approve accreditations applications")) {
            $searchModel = new AccreditationApplicationsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->query->andFilterWhere(['type' => "Consultative"]);
            // $dataProvider->query->andFilterWhere(['NOT IN', "status",]);

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
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Lists all National AccreditationApplications models.
     *
     * @return string
     */
    public function actionNational() {
        if (User::isUserAllowedTo("View applications") ||
                User::isUserAllowedTo("Review national accreditations") ||
                User::isUserAllowedTo("Approve accreditations applications")) {
            $searchModel = new AccreditationApplicationsSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $dataProvider->query->andFilterWhere(['type' => "National"]);

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
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    /**
     * Lists all AccreditationApplications models.
     *
     * @return string
     */
    public function actionIndex() {
        $searchModel = new AccreditationApplicationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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
        if (User::isUserAllowedTo("View applications") ||
                User::isUserAllowedTo("Review consultative accreditations") ||
                User::isUserAllowedTo("Approve accreditations applications")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionViewNational($id) {
        if (User::isUserAllowedTo("View applications") ||
                User::isUserAllowedTo("Review national accreditations") ||
                User::isUserAllowedTo("Approve accreditations applications")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionReview($id) {
        if (User::isUserAllowedTo("Review consultative accreditations")) {
            $model = $this->findModel($id);
            if (!empty($model) && $model->status == AccreditationApplications::SUBMITTED) {
                $reviewModel = new ReviewModel();

                if ($this->request->isPost) {
                    if ($reviewModel->load($this->request->post())) {
                        //Approvals
                        $accreditationApprovals = AcreditationApplicationApprovals::findOne(['application' => $id]);
                        $accreditationApprovals->status_accreditation_officer = $reviewModel->recommendation;
                        $accreditationApprovals->remarks_accreditation_officer = $reviewModel->remarks;
                        $accreditationApprovals->acreditation_officer = Yii::$app->user->id;
                        $accreditationApprovals->approval_date_accreditation_officer = date("Y-m-d H:i:s");
                        $dueDiligenceReport = \yii\web\UploadedFile::getInstance($reviewModel, 'dueDiligenceReport');
                        $accreditationApprovals->due_diligence_report = Yii::$app->security->generateRandomString() . "." . $dueDiligenceReport->extension;
                        $dueDiligenceReport->saveAs(Yii::getAlias('@backend') . '/web/uploads/' . $accreditationApprovals->due_diligence_report);

                        //Applications
                        $model->status = AccreditationApplications::REVIEWED;
                        if ($accreditationApprovals->save(false) && $model->save(false)) {
                            Yii::$app->session->setFlash('success', "Application review successfully saved and sent for final approval");
                            return $this->redirect(['consultative']);
                        } else {
                            Yii::$app->session->setFlash('error', "Application review could not be saved. Please try again!");
                        }
                    }
                }

                return $this->render('review', [
                            'model' => $model,
                            'reviewModel' => $reviewModel,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'This application has already been reviewed!');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionApprove($id) {
        if (User::isUserAllowedTo("Approve accreditations applications")) {
            $model = $this->findModel($id);
            if (!empty($model) && $model->status == AccreditationApplications::REVIEWED) {
                $reviewModel = new ApprovalModel();
                if ($this->request->isPost) {
                    if ($reviewModel->load($this->request->post())) {
                        //Approvals
                        $accreditationApprovals = AcreditationApplicationApprovals::findOne(['application' => $id]);
                        $accreditationApprovals->status_head_of_programs = $reviewModel->recommendation;
                        $accreditationApprovals->remarks_head_of_programs = $reviewModel->remarks;
                        $accreditationApprovals->head_of_programs = Yii::$app->user->id;
                        $accreditationApprovals->approval_date_head_of_programs = date("Y-m-d H:i:s");

                        //Applications
                        if ($reviewModel->recommendation == 1) {
                            $model->status = AccreditationApplications::APPROVED;
                            //Lets generate the accreditation number
                            $model->number = $this->generateAccreditationNumber();
                        }
                        if ($reviewModel->recommendation == 2) {
                            $model->status = AccreditationApplications::DIFFERED;
                        }
                        if ($reviewModel->recommendation == 3) {
                            $model->status = AccreditationApplications::DENIED;
                        }

                        //Generate accreditation number
                        if ($accreditationApprovals->save(false) && $model->save(false)) {
                            Yii::$app->session->setFlash('success', "Application was successfully approved");
                            return $this->redirect(['consultative']);
                        } else {
                            Yii::$app->session->setFlash('error', "Application could not be approved. Please try again!");
                        }
                    }
                }

                return $this->render('approve', [
                            'model' => $model,
                            'reviewModel' => $reviewModel,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'This application has already been approved!');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionReviewNational($id) {
        if (User::isUserAllowedTo("Review national accreditations")) {
            $model = $this->findModel($id);
            if (!empty($model) && $model->status == AccreditationApplications::SUBMITTED) {
                $reviewModel = new ReviewModel();

                if ($this->request->isPost) {
                    if ($reviewModel->load($this->request->post())) {
                        //Approvals
                        $accreditationApprovals = AcreditationApplicationApprovals::findOne(['application' => $id]);
                        $accreditationApprovals->status_accreditation_officer = $reviewModel->recommendation;
                        $accreditationApprovals->remarks_accreditation_officer = $reviewModel->remarks;
                        $accreditationApprovals->acreditation_officer = Yii::$app->user->id;
                        $accreditationApprovals->approval_date_accreditation_officer = date("Y-m-d H:i:s");
                        $dueDiligenceReport = \yii\web\UploadedFile::getInstance($reviewModel, 'dueDiligenceReport');
                        $accreditationApprovals->due_diligence_report = Yii::$app->security->generateRandomString() . "." . $dueDiligenceReport->extension;
                        $dueDiligenceReport->saveAs(Yii::getAlias('@backend') . '/web/uploads/' . $accreditationApprovals->due_diligence_report);

                        //Applications
                        $model->status = AccreditationApplications::REVIEWED;
                        if ($accreditationApprovals->save(false) && $model->save(false)) {
                            Yii::$app->session->setFlash('success', "Application review successfully saved and sent for final approval");
                            return $this->redirect(['national']);
                        } else {
                            Yii::$app->session->setFlash('error', "Application review could not be saved. Please try again!");
                        }
                    }
                }

                return $this->render('review-national', [
                            'model' => $model,
                            'reviewModel' => $reviewModel,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'This application has already been reviewed!');
                return $this->redirect(['view-national', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    public function actionApproveNational($id) {
        if (User::isUserAllowedTo("Approve accreditations applications")) {
            $model = $this->findModel($id);
            if (!empty($model) && $model->status == AccreditationApplications::REVIEWED) {
                $reviewModel = new ApprovalModel();
                if ($this->request->isPost) {
                    if ($reviewModel->load($this->request->post())) {
                        //Approvals
                        $accreditationApprovals = AcreditationApplicationApprovals::findOne(['application' => $id]);
                        $accreditationApprovals->status_head_of_programs = $reviewModel->recommendation;
                        $accreditationApprovals->remarks_head_of_programs = $reviewModel->remarks;
                        $accreditationApprovals->head_of_programs = Yii::$app->user->id;
                        $accreditationApprovals->approval_date_head_of_programs = date("Y-m-d H:i:s");

                        //Applications
                        if ($reviewModel->recommendation == 1) {
                            $model->status = AccreditationApplications::APPROVED;
                            //Lets generate the accreditation number
                            $model->number = $this->generateAccreditationNumber();
                        }
                        if ($reviewModel->recommendation == 2) {
                            $model->status = AccreditationApplications::DIFFERED;
                        }
                        if ($reviewModel->recommendation == 3) {
                            $model->status = AccreditationApplications::DENIED;
                        }

                        //Generate accreditation number
                        if ($accreditationApprovals->save(false) && $model->save(false)) {
                            Yii::$app->session->setFlash('success', "Application was successfully approved");
                            return $this->redirect(['national']);
                        } else {
                            Yii::$app->session->setFlash('error', "Application could not be approved. Please try again!");
                        }
                    }
                }

                return $this->render('approve-national', [
                            'model' => $model,
                            'reviewModel' => $reviewModel,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'This application has already been approved!');
                return $this->redirect(['view-national', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action. This action will be reported');
            return $this->redirect(['home/index']);
        }
    }

    protected static function generateAccreditationNumber() {
        return date("ymdhis");
    }

    /**
     * Creates a new AccreditationApplications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new AccreditationApplications();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionPrintCertificate($id) {
        $model = AccreditationApplications::findOne($id);
        $filename = $model->organisation0->name . "_" . $model->type . ".pdf";
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('print-certificate', ['model' => $model]),
            'options' => [
                'text_input_as_HTML' => true,
                'justifyB4br' => true
            // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'Accreditation certificate',
                //'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['AU/ECOSOCC/Certificate'],
            ]
        ]);
        $pdf->filename = $filename;
        return $pdf->render();
    }

    public function actionDownload($file, $filename, $folder = "") {
        // This will need to be the path relative to the root of your app.
        $filePath = Yii::getAlias('@frontend') . '/web/uploads/' . $folder;
        // Might need to change '@app' for another alias
        $completePath = $filePath . '/' . $file;

        return Yii::$app->response->sendFile($completePath, $filename);
    }

    public function actionDownloadDuediligence($file, $filename) {
        // This will need to be the path relative to the root of your app.
        $filePath = Yii::getAlias('@backend') . '/web/uploads/';
        // Might need to change '@app' for another alias
        $completePath = $filePath . '/' . $file;

        return Yii::$app->response->sendFile($completePath, $filename);
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

}
