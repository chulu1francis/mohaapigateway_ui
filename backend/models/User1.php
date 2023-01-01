<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use borales\extensions\phoneInput\PhoneInputValidator;
use backend\models\Campuses;
use backend\models\Schools;
use backend\models\Departments;
use backend\models\AauthGroups;
use backend\models\AauthPerm;
use backend\models\AauthPermToGroup;


class User1 extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;

    public $campus;
    public $school;
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['group', 'first_name', 'last_name', 'email', 'active', 'auth_key', 'password_hash',
            'department', 'username', 'title', 'man_number'], 'required'],
            [['group', 'active', 'login_attempts', 'updated_by', 'created_by', 'created_at', 'updated_at', 'department'], 'default', 'value' => null],
            [['group', 'active', 'login_attempts', 'updated_by', 'created_by', 'created_at', 'updated_at', 'department'], 'integer'],
            [['email', 'password_hash', 'verification_token', 'ip_address', 'lms_account_created'], 'string'],
            [['image'], 'file',
                'extensions' => 'jpg, jpeg, png',
                'mimeTypes' => 'image/jpg,image/jpeg, image/png',
                'wrongExtension' => 'Only image files(jpeg,jpg,png) are allowed'],
            [['expiry_date', 'last_login'], 'safe'],
            [['first_name', 'last_name', 'phone', 'password_reset_token', 'other_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], PhoneInputValidator::className()],
            ['phone', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('phone_number');
                }, 'message' => 'Mobile number already in use!'],
            [['man_number'], 'number', 'message' => "Man no must be a number!"],
            [['username'], 'number', 'message' => "Username must be a number!"],
            ['email', 'email', 'message' => "The email isn't correct!"],
            ['email', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('email');
                }, 'message' => 'Email already in use!'],
            ['man_number', 'unique', 'when' => function ($model) {
                    return $model->isAttributeChanged('man_number');
                }, 'message' => 'Man number already in use!'],
            [['group'], 'exist', 'skipOnError' => true, 'targetClass' => AauthGroups::class, 'targetAttribute' => ['group' => 'id']],
            [['department'], 'exist', 'skipOnError' => true, 'targetClass' => Departments::class, 'targetAttribute' => ['department' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'other_name' => 'Other name',
            'phone' => 'Phone',
            'email' => 'Email',
            'active' => 'Status',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password reset token',
            'verification_token' => 'Verification token',
            'ip_address' => 'Ip address',
            'login_attempts' => 'Login attempts',
            'updated_by' => 'Updated by',
            'created_by' => 'Created by',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'man_number' => 'Man no',
            'expiry_date' => 'Password expiry',
            'department' => 'Department',
            'username' => 'Username',
            'last_login' => 'Last login',
            'title' => 'Title',
            'lms_account_created' => 'LMS account status',
        ];
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
     * Gets query for [[AauthGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthGroups() {
        return $this->hasMany(AauthGroups::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthGroups0() {
        return $this->hasMany(AauthGroups::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups() {
        return $this->hasMany(AauthPermToGroup::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToGroups0() {
        return $this->hasMany(AauthPermToGroup::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers() {
        return $this->hasMany(AauthPermToUser::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers0() {
        return $this->hasMany(AauthPermToUser::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthPermToUsers1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthPermToUsers1() {
        return $this->hasMany(AauthPermToUser::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups() {
        return $this->hasMany(AauthUserToGroup::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups0() {
        return $this->hasMany(AauthUserToGroup::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AauthUserToGroups1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAauthUserToGroups1() {
        return $this->hasMany(AauthUserToGroup::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AcademicIntakes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicIntakes() {
        return $this->hasMany(AcademicIntakes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AcademicIntakes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicIntakes0() {
        return $this->hasMany(AcademicIntakes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AcademicSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicSessions() {
        return $this->hasMany(AcademicSessions::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AcademicSessions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicSessions0() {
        return $this->hasMany(AcademicSessions::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AdmissionEligibilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionEligibilities() {
        return $this->hasMany(AdmissionEligibility::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AdmissionEligibilities0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionEligibilities0() {
        return $this->hasMany(AdmissionEligibility::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[AdmissionEligibilityRequiredSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionEligibilityRequiredSubjects() {
        return $this->hasMany(AdmissionEligibilityRequiredSubjects::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AdmissionEligibilityRequiredSubjects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionEligibilityRequiredSubjects0() {
        return $this->hasMany(AdmissionEligibilityRequiredSubjects::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationFeePayments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationFeePayments() {
        return $this->hasMany(ApplicationFeePayments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationFeePayments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationFeePayments0() {
        return $this->hasMany(ApplicationFeePayments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationFees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationFees() {
        return $this->hasMany(ApplicationFees::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationFees0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationFees0() {
        return $this->hasMany(ApplicationFees::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationPeriodProgrames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPeriodProgrames() {
        return $this->hasMany(ApplicationPeriodProgrames::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationPeriodProgrames0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPeriodProgrames0() {
        return $this->hasMany(ApplicationPeriodProgrames::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationPeriods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPeriods() {
        return $this->hasMany(ApplicationPeriods::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ApplicationPeriods0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPeriods0() {
        return $this->hasMany(ApplicationPeriods::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Campuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCampuses() {
        return $this->hasMany(Campuses::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Campuses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCampuses0() {
        return $this->hasMany(Campuses::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Centres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCentres() {
        return $this->hasMany(Centres::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Centres0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCentres0() {
        return $this->hasMany(Centres::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(Comments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Comments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments0() {
        return $this->hasMany(Comments::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[CourseGroupings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseGroupings() {
        return $this->hasMany(CourseGroupings::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[CourseGroupings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseGroupings0() {
        return $this->hasMany(CourseGroupings::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[CourseStaff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseStaff() {
        return $this->hasMany(CourseStaff::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[CourseStaff0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseStaff0() {
        return $this->hasMany(CourseStaff::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[CourseStaff1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseStaff1() {
        return $this->hasMany(CourseStaff::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses() {
        return $this->hasMany(Courses::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Courses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses0() {
        return $this->hasMany(Courses::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Department0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment0() {
        return $this->hasOne(Departments::class, ['id' => 'department']);
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments() {
        return $this->hasMany(Departments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Departments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments0() {
        return $this->hasMany(Departments::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Departments1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments1() {
        return $this->hasMany(Departments::class, ['head' => 'id']);
    }

    /**
     * Gets query for [[Disabilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisabilities() {
        return $this->hasMany(Disabilities::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Disabilities0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisabilities0() {
        return $this->hasMany(Disabilities::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts() {
        return $this->hasMany(Districts::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Districts0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts0() {
        return $this->hasMany(Districts::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructureComponentTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructureComponentTypes() {
        return $this->hasMany(ExaminationStructureComponentTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructureComponentTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructureComponentTypes0() {
        return $this->hasMany(ExaminationStructureComponentTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructureComponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructureComponents() {
        return $this->hasMany(ExaminationStructureComponents::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructureComponents0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructureComponents0() {
        return $this->hasMany(ExaminationStructureComponents::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructures() {
        return $this->hasMany(ExaminationStructures::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ExaminationStructures0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExaminationStructures0() {
        return $this->hasMany(ExaminationStructures::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[FeeCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCategories() {
        return $this->hasMany(FeeCategories::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FeeCategories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeCategories0() {
        return $this->hasMany(FeeCategories::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[FeeTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeTypes() {
        return $this->hasMany(FeeTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FeeTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeTypes0() {
        return $this->hasMany(FeeTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[GradingSystemGrades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradingSystemGrades() {
        return $this->hasMany(GradingSystemGrades::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GradingSystemGrades0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradingSystemGrades0() {
        return $this->hasMany(GradingSystemGrades::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[GradingSystems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradingSystems() {
        return $this->hasMany(GradingSystems::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GradingSystems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGradingSystems0() {
        return $this->hasMany(GradingSystems::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Group0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup0() {
        return $this->hasOne(AauthGroups::class, ['id' => 'group']);
    }

    /**
     * Gets query for [[HostelBlocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostelBlocks() {
        return $this->hasMany(HostelBlocks::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[HostelBlocks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostelBlocks0() {
        return $this->hasMany(HostelBlocks::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Hostels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostels() {
        return $this->hasMany(Hostels::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Hostels0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHostels0() {
        return $this->hasMany(Hostels::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[NationalGroupings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationalGroupings() {
        return $this->hasMany(NationalGroupings::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[NationalGroupings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationalGroupings0() {
        return $this->hasMany(NationalGroupings::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Nationalities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationalities() {
        return $this->hasMany(Nationalities::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Nationalities0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationalities0() {
        return $this->hasMany(Nationalities::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Offences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffences() {
        return $this->hasMany(Offences::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Offences0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffences0() {
        return $this->hasMany(Offences::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments() {
        return $this->hasMany(Payments::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ProgramClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgramClasses() {
        return $this->hasMany(ProgramClasses::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ProgramClasses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProgramClasses0() {
        return $this->hasMany(ProgramClasses::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Programs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms() {
        return $this->hasMany(Programs::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Programs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms0() {
        return $this->hasMany(Programs::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[RoomProperties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomProperties() {
        return $this->hasMany(RoomProperties::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RoomProperties0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomProperties0() {
        return $this->hasMany(RoomProperties::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[RoomPropertyTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomPropertyTypes() {
        return $this->hasMany(RoomPropertyTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RoomPropertyTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomPropertyTypes0() {
        return $this->hasMany(RoomPropertyTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[RoomTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomTypes() {
        return $this->hasMany(RoomTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RoomTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomTypes0() {
        return $this->hasMany(RoomTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Rooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRooms() {
        return $this->hasMany(Rooms::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Rooms0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRooms0() {
        return $this->hasMany(Rooms::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Schools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools() {
        return $this->hasMany(Schools::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Schools0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchools0() {
        return $this->hasMany(Schools::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SecondarySchoolSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecondarySchoolSubjects() {
        return $this->hasMany(SecondarySchoolSubjects::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SecondarySchoolSubjects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecondarySchoolSubjects0() {
        return $this->hasMany(SecondarySchoolSubjects::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SecondarySchools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecondarySchools() {
        return $this->hasMany(SecondarySchools::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SecondarySchools0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSecondarySchools0() {
        return $this->hasMany(SecondarySchools::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SessionMinimumTuitionPayments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionMinimumTuitionPayments() {
        return $this->hasMany(SessionMinimumTuitionPayments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SessionMinimumTuitionPayments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionMinimumTuitionPayments0() {
        return $this->hasMany(SessionMinimumTuitionPayments::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SessionPaymentPlans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionPaymentPlans() {
        return $this->hasMany(SessionPaymentPlans::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SessionPaymentPlans0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionPaymentPlans0() {
        return $this->hasMany(SessionPaymentPlans::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SessionRegistrationPeriods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionRegistrationPeriods() {
        return $this->hasMany(SessionRegistrationPeriods::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SessionRegistrationPeriods0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessionRegistrationPeriods0() {
        return $this->hasMany(SessionRegistrationPeriods::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Sponsors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSponsors() {
        return $this->hasMany(Sponsors::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Sponsors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSponsors0() {
        return $this->hasMany(Sponsors::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[SponsorshipPercentages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSponsorshipPercentages() {
        return $this->hasMany(SponsorshipPercentages::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SponsorshipPercentages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSponsorshipPercentages0() {
        return $this->hasMany(SponsorshipPercentages::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentComments() {
        return $this->hasMany(StudentComments::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentComments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentComments0() {
        return $this->hasMany(StudentComments::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFiles() {
        return $this->hasMany(StudentFiles::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentFiles0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFiles0() {
        return $this->hasMany(StudentFiles::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentGuardians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGuardians() {
        return $this->hasMany(StudentGuardian::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentGuardians0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGuardians0() {
        return $this->hasMany(StudentGuardian::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentLocations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentLocations() {
        return $this->hasMany(StudentLocation::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentLocations0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentLocations0() {
        return $this->hasMany(StudentLocation::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentOffences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentOffences() {
        return $this->hasMany(StudentOffences::class, ['cleared_by' => 'id']);
    }

    /**
     * Gets query for [[StudentOffences0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentOffences0() {
        return $this->hasMany(StudentOffences::class, ['cleared_by' => 'id']);
    }

    /**
     * Gets query for [[StudentOffences1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentOffences1() {
        return $this->hasMany(StudentOffences::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentPreviousInstitutions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPreviousInstitutions() {
        return $this->hasMany(StudentPreviousInstitution::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentPreviousInstitutions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPreviousInstitutions0() {
        return $this->hasMany(StudentPreviousInstitution::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentProgrames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentProgrames() {
        return $this->hasMany(StudentProgrames::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentProgrames0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentProgrames0() {
        return $this->hasMany(StudentProgrames::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentReferences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentReferences() {
        return $this->hasMany(StudentReferences::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentReferences0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentReferences0() {
        return $this->hasMany(StudentReferences::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentSessionInvoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSessionInvoices() {
        return $this->hasMany(StudentSessionInvoices::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentSponsors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSponsors() {
        return $this->hasMany(StudentSponsors::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentSponsors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSponsors0() {
        return $this->hasMany(StudentSponsors::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentStudyRecords]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentStudyRecords() {
        return $this->hasMany(StudentStudyRecords::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentStudyRecords0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentStudyRecords0() {
        return $this->hasMany(StudentStudyRecords::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudentSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSubjects() {
        return $this->hasMany(StudentSubjects::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentSubjects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSubjects0() {
        return $this->hasMany(StudentSubjects::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents() {
        return $this->hasMany(Students::class, ['staff' => 'id']);
    }

    /**
     * Gets query for [[Students0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents0() {
        return $this->hasMany(Students::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Students1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents1() {
        return $this->hasMany(Students::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Studies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudies() {
        return $this->hasMany(Studies::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Studies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudies0() {
        return $this->hasMany(Studies::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyCourseLoads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyCourseLoads() {
        return $this->hasMany(StudyCourseLoads::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyCourseLoads0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyCourseLoads0() {
        return $this->hasMany(StudyCourseLoads::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyMajors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyMajors() {
        return $this->hasMany(StudyMajors::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyMajors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyMajors0() {
        return $this->hasMany(StudyMajors::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyModes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyModes() {
        return $this->hasMany(StudyModes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyModes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyModes0() {
        return $this->hasMany(StudyModes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyPaths]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyPaths() {
        return $this->hasMany(StudyPaths::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyPaths0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyPaths0() {
        return $this->hasMany(StudyPaths::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyStructures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyStructures() {
        return $this->hasMany(StudyStructures::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyStructures0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyStructures0() {
        return $this->hasMany(StudyStructures::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYearSessionTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYearSessionTypes() {
        return $this->hasMany(StudyYearSessionTypes::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYearSessionTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYearSessionTypes0() {
        return $this->hasMany(StudyYearSessionTypes::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYearSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYearSessions() {
        return $this->hasMany(StudyYearSessions::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYearSessions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYearSessions0() {
        return $this->hasMany(StudyYearSessions::class, ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYears]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYears() {
        return $this->hasMany(StudyYears::class, ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudyYears0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudyYears0() {
        return $this->hasMany(StudyYears::class, ['updated_by' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::find()->cache(3600)->where(['id' => $id, 'active' => self::STATUS_ACTIVE])->one();
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'active' => self::STATUS_ACTIVE]);
    }

    public static function findById($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'active' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByPasswordResetTokenInactiveAccount($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'active' => self::STATUS_INACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'active' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password . $this->auth_key, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password . $this->auth_key);
    }

    public function setStatus() {
        $this->active = self::STATUS_ACTIVE;
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public static function isUserAllowedTo($right) {
        $session = Yii::$app->session;
        $rights = explode(',', $session['rights']);
        if (in_array($right, $rights)) {
            return true;
        }
        return false;
    }

    public static function getActiveUsers() {
        $query = static::find()
                ->where(['active' => self::STATUS_ACTIVE])
                ->orderBy(['man_number' => SORT_ASC])
                ->all();
        return ArrayHelper::map($query, 'id', 'man_number');
    }

    public static function getActiveUsersWithNames() {
        $query = static::find()
                ->select(["CONCAT(CONCAT(first_name,' ',last_name),'-',man_number) as name", 'id'])
                ->where(['active' => self::STATUS_ACTIVE])
                // ->andWhere(['NOT IN', 'first_name', 'Board'])
                ->orderBy(['username' => SORT_ASC])
                ->asArray()
                ->all();
        return ArrayHelper::map($query, 'id', 'name');
    }

    public function getFullName() {
        if (!empty($this->other_name)) {
            return ucfirst(strtolower($this->title)) . " " . ucfirst(strtolower($this->first_name)) . " " .
                    ucfirst(strtolower($this->other_name)) . " " . ucfirst(strtolower($this->last_name));
        }
        return ucfirst(strtolower($this->title)) . " " . ucfirst(strtolower($this->first_name)) . " " .
                ucfirst(strtolower($this->last_name));
    }

    /**
     * 
     * @return type array
     */
    public static function getFullNames() {
        $query = static::find()
                ->select(["CONCAT(CONCAT(first_name,' ',other_name),' ',last_name) as name", 'first_name'])
                ->where(['NOT IN', 'id', Yii::$app->user->id])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        return \yii\helpers\ArrayHelper::map($query, 'first_name', 'name');
    }

    public static function getManNumbers() {
        $query = static::find()
                ->where(['NOT IN', 'id', Yii::$app->user->id])
                ->orderBy(['man_number' => SORT_ASC])
                ->all();
        return ArrayHelper::map($query, 'id', 'man_number');
    }

    /**
     * Function for seeding default system records
     * Campus=Main,School=IT, Department=IT, Group=Administrator, Permissions,
     * Permissions to group and User
     * NOTE:: USER should be removed after an admin user is created
     */
    public static function seeder() {
        //We check if we already have a group called Administrator,
        //Means the seed was already run
        if (empty(AauthGroups::findOne(["name" => "Administrator"]))) {
            $ultimatePermissions = [
                "Manage users", "Manage groups", "View groups", "View users"
            ];

            //1. Create campus
            $campus = new Campuses();
            $campus->name = \Yii::$app->params['defaultCampus'];
            $campus->code = \Yii::$app->params['defaultCampusCode'];
            $campus->address = \Yii::$app->params['defaultCampusAddress'];
            $campus->save(false);

            //2. Create School
            $school = new Schools();
            $school->number = Schools::getSchoolNumber();
            $school->name = \Yii::$app->params['defaultSchoolName'];
            $school->description = \Yii::$app->params['defaultSchoolDescription'];
            $school->campus = $campus->id;
            $school->save(false);

            //3. Create department
            $department = new Departments();
            $department->school = $school->id;
            $department->name = \Yii::$app->params['defaultDepartmentName'];
            $department->code = \Yii::$app->params['defaultDepartmentCode'];
            $department->save(false);

            //4. Create user group
            $group = new AauthGroups();
            $group->name = "Administrator";
            $group->description = "Administrator group";
            $group->save(false);

            //5. Seed permissions
            AauthPerm::seedPermissions();

            //6.Assign ultimate permissions to the group: Administrator
            $count = 0;
            foreach ($ultimatePermissions as $permission) {
                $perm = AauthPerm::findOne(["name" => $permission]);
                $perm_to_group = new AauthPermToGroup();
                $perm_to_group->group = $group->id;
                $perm_to_group->permission = $perm->id;
                $perm_to_group->save(false);
                $count++;
            }

            //7. Create user
            echo self::createTemporaryUser($group->id, $department->id, $count);
        }
    }

    /**
     * Create default user 
     * @param type $group
     * @param type $department
     * @param type $count
     */
    private static function createTemporaryUser($group, $department, $count) {
        if ($count > 0) {
            $model = new User();
            $model->first_name = \Yii::$app->params['defaultUserFirstname'];
            $model->last_name = \Yii::$app->params['defaultUserLastname'];
            $model->title = "Mr.";
            $model->email = \Yii::$app->params['defaultUserEmail'];
            $model->status = self::STATUS_ACTIVE;
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->man_number = \Yii::$app->params['defaultUserManNo'];
            $model->username = \Yii::$app->params['defaultUserManNo'];
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash("Bondwe@134" . $model->auth_key);
            $model->group = $group;
            $model->department = $department;
            $days = \Yii::$app->params['passwordValidity'] * 30;
            $expiryDate = date('Y-m-d', (strtotime('+' . $days . 'days', strtotime(date("Y-m-d")))));
            $model->expiry_date = $expiryDate;

            if ($model->save(false)) {
                echo "User seeding was successful!";
            } else {
                $message = "";
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                echo "Error occured while running user seeder. Could not create user.Errors:" . $message;
            }
        } else {
            echo "Error occured while running user seeder. Could not assign permissions to role!";
        }
    }

}
