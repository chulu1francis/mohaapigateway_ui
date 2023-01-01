<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "acreditation_application_approvals".
 *
 * @property int $id
 * @property int $application
 * @property string $remarks_accreditation_officer
 * @property string $status_accreditation_officer
 * @property string $approval_date_accreditation_officer
 * @property string $remarks_head_of_programs
 * @property string $status_head_of_programs
 * @property string $approval_date_head_of_programs
 * @property int|null $acreditation_officer
 * @property int|null $head_of_programs
 * @property string|null $due_diligence_report
 *
 * @property User $acreditationOfficer
 * @property AccreditationApplications $application0
 * @property User $headOfPrograms
 */
class AcreditationApplicationApprovals extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acreditation_application_approvals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application', 'remarks_accreditation_officer', 'status_accreditation_officer', 'remarks_head_of_programs', 'status_head_of_programs'], 'required'],
            [['application', 'acreditation_officer', 'head_of_programs'], 'default', 'value' => null],
            [['application', 'acreditation_officer', 'head_of_programs'], 'integer'],
            [['remarks_accreditation_officer', 'remarks_head_of_programs', 'due_diligence_report'], 'string'],
            [['approval_date_accreditation_officer', 'approval_date_head_of_programs'], 'safe'],
            [['status_accreditation_officer', 'status_head_of_programs'], 'string', 'max' => 15],
            [['acreditation_officer'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['acreditation_officer' => 'id']],
            [['head_of_programs'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['head_of_programs' => 'id']],
            [['application'], 'exist', 'skipOnError' => true, 'targetClass' => AccreditationApplications::class, 'targetAttribute' => ['application' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application' => 'Application',
            'remarks_accreditation_officer' => 'Remarks Accreditation Officer',
            'status_accreditation_officer' => 'Status Accreditation Officer',
            'approval_date_accreditation_officer' => 'Approval Date Accreditation Officer',
            'remarks_head_of_programs' => 'Remarks Head Of Programs',
            'status_head_of_programs' => 'Status Head Of Programs',
            'approval_date_head_of_programs' => 'Approval Date Head Of Programs',
            'acreditation_officer' => 'Acreditation Officer',
            'head_of_programs' => 'Head Of Programs',
            'due_diligence_report' => 'Due Diligence Report',
        ];
    }

    /**
     * Gets query for [[AcreditationOfficer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcreditationOfficer()
    {
        return $this->hasOne(User::class, ['id' => 'acreditation_officer']);
    }

    /**
     * Gets query for [[Application0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplication0()
    {
        return $this->hasOne(AccreditationApplications::class, ['id' => 'application']);
    }

    /**
     * Gets query for [[HeadOfPrograms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeadOfPrograms()
    {
        return $this->hasOne(User::class, ['id' => 'head_of_programs']);
    }
}
