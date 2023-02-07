<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Requests;
use Yii;

/**
 * RequestsSearch represents the model behind the search form of `backend\models\Requests`.
 */
class RequestsSearch extends Requests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client', 'status', 'payment_status'], 'integer'],
            [['request', 'path', 'source_ip', 'source_agent', 'created_at', 'updated_at', 'proof_of_payment'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Requests::find()->cache(Yii::$app->params['cacheDuration']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client' => $this->client,
            'status' => $this->status,
            'amount' => $this->amount,
            'payment_status' => $this->payment_status,
            //'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'request', $this->request])
            ->andFilterWhere(['ilike', 'path', $this->path])
            ->andFilterWhere(['ilike', 'source_ip', $this->source_ip])
            ->andFilterWhere(['ilike', 'source_agent', $this->source_agent])
            ->andFilterWhere(['ilike', 'proof_of_payment', $this->proof_of_payment]);

        return $dataProvider;
    }
}
