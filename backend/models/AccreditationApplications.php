<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Currencies;
use frontend\models\Organisations;

/**
 * This is the model class for table "accreditation_applications".
 *
 * @property int $id
 * @property int $organisation
 * @property int $currency
 * @property string $type
 * @property string $status
 * @property float $income
 * @property float $expenditure
 * @property string $letter
 * @property string $registration_or_acknowledgement_certificate
 * @property string $certified_articles_of_association
 * @property string $bylaws
 * @property string $statutes_or_constitution_detailing_the_mandate
 * @property string $scope_and_governing_structure_or_organisational_profile
 * @property string $annual_income_and_expenditure_statement
 * @property string $names_of_all_donors_and_other_funding_sources_last_two_years
 * @property string $evidence_of_competency_in_thematic_areas
 * @property string|null $other_relevant_documents
 * @property int $compliance_with_au_data_policy
 * @property int $created_at
 * @property int|null $updated_at
 * @property string|null $number
 *
 * @property AcreditationApplicationApprovals[] $acreditationApplicationApprovals
 * @property Currencies $currency0
 * @property Organisations $organisation0
 */
class AccreditationApplications extends ActiveRecord {

    const NOT_SUBMITTED = "Not submitted";
    const SUBMITTED = "Submitted";
    const REVIEWED= "Reviewed";
    const DIFFERED = "Differed";
    const APPROVED = "Approved";
    const DENIED = "Denied";

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'accreditation_applications';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['organisation', 'currency', 'type', 'status', 'letter', 'registration_or_acknowledgement_certificate', 'certified_articles_of_association', 'bylaws',
            'statutes_or_constitution_detailing_the_mandate', 'scope_and_governing_structure_or_organisational_profile', 'annual_income_and_expenditure_statement',
            'names_of_all_donors_and_other_funding_sources_last_two_years', 'evidence_of_competency_in_thematic_areas',
                'income', 'expenditure','compliance_with_au_data_policy'], 'required'],
            [['organisation', 'currency', 'compliance_with_au_data_policy', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organisation', 'currency', 'compliance_with_au_data_policy', 'created_at', 'updated_at'], 'integer'],
           // [['income', 'expenditure'], 'number'],
            [['letter', 'registration_or_acknowledgement_certificate', 'certified_articles_of_association', 'bylaws', 'statutes_or_constitution_detailing_the_mandate',
            'scope_and_governing_structure_or_organisational_profile', 'annual_income_and_expenditure_statement', 'names_of_all_donors_and_other_funding_sources_last_two_years',
            'evidence_of_competency_in_thematic_areas', 'other_relevant_documents'],
                'file', 'extensions' => 'pdf',
                'mimeTypes' => ['application/pdf'],
                'wrongExtension' => 'Only pdf files are allowed'],
            ['expenditure', 'checkIncomeExpenditureDifference'],
            [['type'], 'string', 'max' => 45],
            [['status'], 'string', 'max' => 20],
            [['number'], 'string', 'max' => 25],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::class, 'targetAttribute' => ['currency' => 'id']],
            [['organisation'], 'exist', 'skipOnError' => true, 'targetClass' => Organisations::class, 'targetAttribute' => ['organisation' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'organisation' => 'Organisation',
            'currency' => 'Currency',
            'type' => 'Type',
            'status' => 'Status',
            'income' => 'Income',
            'expenditure' => 'Expenditure',
            'letter' => 'Application letter',
            'registration_or_acknowledgement_certificate' => 'Registration or Acknowledgement Certificate',
            'certified_articles_of_association' => 'Certified Articles Of Association',
            'bylaws' => 'Bylaws',
            'statutes_or_constitution_detailing_the_mandate' => 'Statutes Or Constitution Detailing The Mandate',
            'scope_and_governing_structure_or_organisational_profile' => 'Scope And Governing Structure Or Organisational Profile',
            'annual_income_and_expenditure_statement' => 'Annual Income And Expenditure Statement',
            'names_of_all_donors_and_other_funding_sources_last_two_years' => 'Names Of All Donors And Other Funding Sources Last Two Years',
            'evidence_of_competency_in_thematic_areas' => 'Evidence Of Competency In Thematic Areas',
            'other_relevant_documents' => 'Other Relevant Documents',
            'compliance_with_au_data_policy' => 'Compliance with AU data policy',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'number' => 'Number',
        ];
    }

    public function checkIncomeExpenditureDifference() {
        if (!empty($this->income) && !empty($this->expenditure)) {
            if ($this->income < $this->expenditure) {
                $this->addError('expenditure', "Income must be more than your expenditure");
            }
        }
    }

    /**
     * Gets query for [[AcreditationApplicationApprovals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcreditationApplicationApprovals() {
        return $this->hasMany(AcreditationApplicationApprovals::class, ['application' => 'id']);
    }

    /**
     * Gets query for [[Currency0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0() {
        return $this->hasOne(Currencies::class, ['id' => 'currency']);
    }

    /**
     * Gets query for [[Organisation0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisation0() {
        return $this->hasOne(Organisations::class, ['id' => 'organisation']);
    }

}
