<?php

namespace frontend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Organisations;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use frontend\models\OrganisationAreaOfExpertise;
use backend\models\SubCategories;
use frontend\models\OrganisationRegistrationDetails;
use frontend\models\OrganisationContactPersons;
use frontend\models\OrganisationContactPersonsSearch;

class HomeController extends \yii\web\Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['index', 'update-profile', 'update-logo',
                            'subcategories', 'add-area-of-expertise', 'delete-area-of-expertise',
                            'add-registration-details', 'update-registration-details', 'add-contact-person',
                            'update-contact-person', 'delete-contact-person'],
                        'rules' => [
                            [
                                'actions' => ['index', 'update-profile', 'update-logo',
                                    'subcategories', 'add-area-of-expertise', 'delete-area-of-expertise',
                                    'add-registration-details', 'update-registration-details', 'add-contact-person',
                                    'update-contact-person', 'delete-contact-person'],
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
     * Creates a new OrganisationContactPersons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAddContactPerson($id) {
        $model = new OrganisationContactPersons();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->organisation = $id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Contact person successfully added');
                return $this->redirect(['index']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', 'Error occured while adding contact person. Please try again later!' . $message);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('add-contact-person', [
                    'model' => $model,
                    'id' => $id,
        ]);
    }

    /**
     * Updates an existing OrganisationContactPersons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateContactPerson($id) {
        $model = OrganisationContactPersons::findOne($id);
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Contact person successfully updated');
                return $this->redirect(['index']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', 'Error occured while updating contact person. Please try again later!' . $message);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update-contact-person', [
                    'model' => $model,
                    'id' => $id,
        ]);
    }

    /**
     * Creates a new OrganisationRegistrationDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAddRegistrationDetails($id) {
        $model = new OrganisationRegistrationDetails();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->years_of_experience = OrganisationRegistrationDetails::getYears($model->registration_date, $model->registration_expiry_date);
            $model->organisation = $id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registration details successfully added');
                return $this->redirect(['index']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', 'Error occured while adding registration details. Please try again later!');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-registration-details', [
                    'model' => $model,
                    'id' => $id,
        ]);
    }

    /**
     * Updates an existing OrganisationRegistrationDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateRegistrationDetails($id) {
        $model = OrganisationRegistrationDetails::findOne($id);
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->years_of_experience = OrganisationRegistrationDetails::getYears($model->registration_date, $model->registration_expiry_date);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registration details successfully updated');
                return $this->redirect(['index']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', 'Error occured while updating registration details. Please try again later!');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update-registration-details', [
                    'model' => $model,
                    'id' => $id,
        ]);
    }

    public function actionIndex() {
        $areasOfExpertise = OrganisationAreaOfExpertise::find()
                ->where(['organisation' => Yii::$app->user->id])
                ->orderBy('created_at DESC')
                ->all();
        $registrationDetails = OrganisationRegistrationDetails::findOne(['organisation' => Yii::$app->user->id]);
        $searchModel = new OrganisationContactPersonsSearch();
        $dataProviderContactPersons = $searchModel->search($this->request->queryParams);
         $dataProviderContactPersons->query->andFilterWhere(["organisation" => Yii::$app->user->id]);

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $areasOfExpertise,
            'sort' => [
                'attributes' => [
                    'created_at' => [
                        'DESC' => [
                            'created_at' => SORT_DESC,
                        ],
                    ],
                ],
            ]
        ]);

        $dataProvider->pagination = ['pageSize' => 25];
        $dataProvider->setSort([
            'attributes' => [
                'sub_category' => [
                    'desc' => ['sub_category' => SORT_ASC],
                    'default' => SORT_ASC
                ],
            ],
            'defaultOrder' => [
                'sub_category' => SORT_ASC
            ]
        ]);

        return $this->render('index', [
                    'areasOfExpertise' => $dataProvider,
                    'registrationDetails' => $registrationDetails,
                    'contactPersons' => $dataProviderContactPersons,
        ]);
    }

    public function actionUpdateProfile($id) {
        $model = Organisations::findOne($id);
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->username = $model->email;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Organisation profile details successfull updated");
                return $this->redirect(['index']);
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', "Error occured while updating details.Please try again.Error::" . $message);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionUpdateLogo($id) {
        $model = Organisations::findOne($id);

        $oldFile = $model->logo;
        if ($this->request->isPost && $model->load($this->request->post())) {
            $logo = \yii\web\UploadedFile::getInstance($model, 'logo');

            //Lets save the logo
            if (!empty($logo)) {
                $model->logo = Yii::$app->security->generateRandomString() . "." . $logo->extension;
                $logo->saveAs(Yii::getAlias('@frontend') . '/web/uploads/' . $model->logo);

                if ($model->save(false)) {
                    //We change the logo name in the session
                    Yii::$app->session->set('logo', $model->logo);
                    //Lets remove the old file
                    if (!empty($oldFile)) {
                        if (file_exists(Yii::getAlias('@frontend') . '/web/uploads/' . $oldFile)) {
                            unlink(Yii::getAlias('@frontend') . '/web/uploads/' . $oldFile);
                        }
                    }

                    Yii::$app->session->setFlash('success', "Organisation logo successfull updated");
                } else {
                    $message = '';
                    foreach ($model->getErrors() as $error) {
                        $message .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', "Error occured while updating logo.Please try again.Error::" . $message);
                }
            }
        }

        return $this->redirect(['index']);
    }

    public function actionAddAreaOfExpertise($id) {

        $model = new OrganisationAreaOfExpertise();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $count = 0;

//            var_dump($this->request->post()['OrganisationAreaOfExpertise']['sub_category']);
//            exit();
            foreach ($this->request->post()['OrganisationAreaOfExpertise']['sub_category'] as $subcategory) {
                $model = new OrganisationAreaOfExpertise();
                $model->organisation = $id;
                $model->sub_category = $subcategory;
                $model->save(false);
                $count++;
            }

            if ($count > 0) {
                Yii::$app->session->setFlash('success', "Organisation areas of expertise successfull saved");
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', "Error occured while adding Organisation areas of expertise.Please try again.Error::" . $message);
            }
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteAreaOfExpertise($id) {
        try {
            $model = OrganisationAreaOfExpertise::findOne($id);

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Area of expertise was successfully deleted.');
            } else {
                Yii::$app->session->setFlash('error', 'Area of expertise could not be deleted. Please try again!');
            }
            return $this->redirect(['index']);
        } catch (yii\db\IntegrityException | Exception $ex) {
            Yii::$app->session->setFlash('error', 'Error occured while removing area of expertise. Please try again!');
            return $this->redirect(['index']);
        }
    }

    public function actionDeleteContactPerson($id) {
        try {
            $model = OrganisationContactPersons::findOne($id);

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Contact person was successfully removed.');
            } else {
                Yii::$app->session->setFlash('error', 'Contact person could not be removed. Please try again!');
            }
            return $this->redirect(['index']);
        } catch (yii\db\IntegrityException | Exception $ex) {
            Yii::$app->session->setFlash('error', 'Error occured while removing contact person. Please try again!');
            return $this->redirect(['index']);
        }
    }

    public function actionSubcategories() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $category = $parents[0];
                $subcategoriesArray = [];
                //We make sure we filter out those areas added already
                $orgSubcategories = OrganisationAreaOfExpertise::find()
                        ->where(['organisation' => Yii::$app->user->id])
                        ->asArray()
                        ->all();

                foreach ($orgSubcategories as $areaOfExpertise) {
                    $result = SubCategories::findOne(['category' => $category, 'id' => $areaOfExpertise['sub_category']]);
                    if (!empty($result)) {
                        array_push($subcategoriesArray, $areaOfExpertise['sub_category']);
                    }
                }

                if (!empty($subcategoriesArray)) {
                    $out = SubCategories::find()
                            ->select(['id', 'name'])
                            ->where(['category' => $category])
                            ->andWhere(["NOT IN", 'id', $subcategoriesArray])
                            ->asArray()
                            ->all();
                } else {
                    $out = SubCategories::find()
                            ->select(['id', 'name'])
                            ->where(['category' => $category])
                            ->asArray()
                            ->all();
                }

                return ['output' => $out, 'selected' => ""];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

}
