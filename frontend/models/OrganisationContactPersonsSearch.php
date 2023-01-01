<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrganisationContactPersons;

/**
 * OrganisationContactPersonsSearch represents the model behind the search form of `frontend\models\OrganisationContactPersons`.
 */
class OrganisationContactPersonsSearch extends OrganisationContactPersons
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organisation', 'country', 'created_at', 'updated_at'], 'integer'],
            [['title', 'formal_title', 'first_name', 'last_name', 'other_names', 'department', 'telephone', 'mobile', 'fax', 'whatsapp_number', 'email'], 'safe'],
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
        $query = OrganisationContactPersons::find();

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
            'organisation' => $this->organisation,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'formal_title', $this->formal_title])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'other_names', $this->other_names])
            ->andFilterWhere(['ilike', 'department', $this->department])
            ->andFilterWhere(['ilike', 'telephone', $this->telephone])
            ->andFilterWhere(['ilike', 'mobile', $this->mobile])
            ->andFilterWhere(['ilike', 'fax', $this->fax])
            ->andFilterWhere(['ilike', 'whatsapp_number', $this->whatsapp_number])
            ->andFilterWhere(['ilike', 'email', $this->email]);

        return $dataProvider;
    }
}
