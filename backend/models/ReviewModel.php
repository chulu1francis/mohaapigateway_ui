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
class ReviewModel extends \yii\base\Model {

    public $dueDiligenceReport;
    public $remarks;
    public $recommendation;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['dueDiligenceReport', 'remarks', 'recommendation'], 'required'],
            [['dueDiligenceReport'], 'file',
                'extensions' => 'pdf',
                'mimeTypes' => ['application/pdf'],
                'wrongExtension' => 'Only pdf files are allowed'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'dueDiligenceReport' => 'Due diligence report',
            'remarks' => 'Remarks',
            'recommendation' => 'Recommendation',
        ];
    }

}
