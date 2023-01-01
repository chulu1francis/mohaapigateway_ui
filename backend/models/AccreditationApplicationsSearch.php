<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AccreditationApplications;

/**
 * AccreditationApplicationsSearch represents the model behind the search form of `backend\models\AccreditationApplications`.
 */
class AccreditationApplicationsSearch extends AccreditationApplications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organisation', 'currency', 'compliance_with_au_data_policy', 'created_at', 'updated_at'], 'integer'],
            [['type', 'status', 'letter', 'registration_or_acknowledgement_certificate', 'certified_articles_of_association', 'bylaws', 'statutes_or_constitution_detailing_the_mandate', 'scope_and_governing_structure_or_organisational_profile', 'annual_income_and_expenditure_statement', 'names_of_all_donors_and_other_funding_sources_last_two_years', 'evidence_of_competency_in_thematic_areas', 'other_relevant_documents', 'number'], 'safe'],
            [['income', 'expenditure'], 'number'],
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
        $query = AccreditationApplications::find();

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
            'currency' => $this->currency,
            'income' => $this->income,
            'expenditure' => $this->expenditure,
            'compliance_with_au_data_policy' => $this->compliance_with_au_data_policy,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'status', $this->status])
            ->andFilterWhere(['ilike', 'letter', $this->letter])
            ->andFilterWhere(['ilike', 'registration_or_acknowledgement_certificate', $this->registration_or_acknowledgement_certificate])
            ->andFilterWhere(['ilike', 'certified_articles_of_association', $this->certified_articles_of_association])
            ->andFilterWhere(['ilike', 'bylaws', $this->bylaws])
            ->andFilterWhere(['ilike', 'statutes_or_constitution_detailing_the_mandate', $this->statutes_or_constitution_detailing_the_mandate])
            ->andFilterWhere(['ilike', 'scope_and_governing_structure_or_organisational_profile', $this->scope_and_governing_structure_or_organisational_profile])
            ->andFilterWhere(['ilike', 'annual_income_and_expenditure_statement', $this->annual_income_and_expenditure_statement])
            ->andFilterWhere(['ilike', 'names_of_all_donors_and_other_funding_sources_last_two_years', $this->names_of_all_donors_and_other_funding_sources_last_two_years])
            ->andFilterWhere(['ilike', 'evidence_of_competency_in_thematic_areas', $this->evidence_of_competency_in_thematic_areas])
            ->andFilterWhere(['ilike', 'other_relevant_documents', $this->other_relevant_documents])
            ->andFilterWhere(['ilike', 'number', $this->number]);

        return $dataProvider;
    }
}
