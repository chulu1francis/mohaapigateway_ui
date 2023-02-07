<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Requests;

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
                        'only' => ['index'],
                        'rules' => [
                            [
                                'actions' => ['index'],
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

    public function actionIndex() {
        $JanRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 1])
                ->count();
        $FebRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 2])
                ->count();
        $marRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 3])
                ->count();
        $aprRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 4])
                ->count();
        $mayRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 5])
                ->count();
        $JuneRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 6])
                ->count();
        $JulyRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 7])
                ->count();
        $augRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 8])
                ->count();
        $sepRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 9])
                ->count();
        $octRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 10])
                ->count();
        $novRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 11])
                ->count();
        $decRequests = Requests::find()
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 12])
                ->count();
        $JanRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 1])
                ->sum('amount');
        $febRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 2])
                ->sum('amount');
        $marRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 3])
                ->sum('amount');
        $aprRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 4])
                ->sum('amount');
        $mayRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 5])
                ->sum('amount');
        $juneRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 6])
                ->sum('amount');
        $julyRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 7])
                ->sum('amount');
        $augRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 8])
                ->sum('amount');
        $sepRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 9])
                ->sum('amount');
        $octRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 10])
                ->sum('amount');
        $novRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 11])
                ->sum('amount');
        $decRevenue = Requests::find()
                ->select(['amount'])
                ->where(['status' => 200])
                ->andWhere(['EXTRACT(MONTH FROM created_at)' => 12])
                ->sum('amount');
        return $this->render('index', [
            'Jan'=>$JanRequests,
            'feb'=>$FebRequests,
            'mar'=>$marRequests,
            'apr'=>$aprRequests,
            'may'=>$mayRequests,
            'june'=>$JuneRequests,
            'july'=>$JulyRequests,
            'aug'=>$augRequests,
            'sep'=>$sepRequests,
            'oct'=>$octRequests,
            'nov'=>$novRequests,
            'dec'=>$decRequests,
            'JanRevenue'=>$JanRevenue,
            'febRevenue'=>$febRevenue,
            'marRevenue'=>$marRevenue,
            'aprRevenue'=>$aprRevenue,
            'mayRevenue'=>$mayRevenue,
            'juneRevenue'=>$juneRevenue,
            'julyRevenue'=>$julyRevenue,
            'augRevenue'=>$augRevenue,
            'sepRevenue'=>$sepRevenue,
            'octRevenue'=>$octRevenue,
            'novRevenue'=>$novRevenue,
            'decRevenue'=>$decRevenue,
            
        ]);
    }

}
