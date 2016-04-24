<?php

namespace app\modules\Dashbord\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\Dashbord\models\AuthAssignment;
use app\components\Helper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $role_id
 * @property integer $status
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $password_salt
 * @property string $auth_key
 * @property string $login_ip
 * @property string $login_time
 * @property string $create_time
 * @property string $update_time
 * @property string $ban_time
 * @property string $ban_reason
 *
 * @property Profile[] $profiles
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $passwordConfirm;
    public $verifyCode;

    /**
     * @var string Current password - for account page updates
     */
    public $old_password;
    public $new_password;
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => function () {
                    return Yii::$app->jdate->date('Y-m-d H:i:s');
                },
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['status'], 'integer'],
            // [['login_time', 'role_id', 'create_time', 'update_time', 'ban_time'], 'safe'],
            //[['email', 'username', 'ban_reason'], 'string', 'max' => 255],
            // password signUp
            [['password'], 'string', 'min' => 6, 'on' => 'signUp'],
            [['password'], 'filter', 'filter' => 'trim', 'on' => 'signUp'],
            [['password', 'passwordConfirm'], 'required', 'on' => 'signUp'],
            [['passwordConfirm'], 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords do not match'), 'on' => 'signUp'],
            [['email', 'username'], 'required'],
            [['email', 'username'], 'string', 'max' => 255],
            [['email', 'username'], 'unique'],
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                'message' => Yii::t("app", "{attribute} can contain only letters, numbers, and '_'.", ["attribute" => '{attribute}'])],
            // [['verifyCode'], 'captcha', 'on' => 'signUp'],
            // password reset
            [['old_password', 'new_password', 'repeat_password'], 'required', 'on' => 'reset'],
            [['new_password', 'repeat_password'], 'string', 'min' => 6, 'on' => 'reset'],
            [['old_password'], 'findPasswords', 'on' => 'reset'],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password', 'on' => 'reset'],
        ];
    }

    //matching the old password with your existing password.
    public function findPasswords() {

        if (!$this->validatePassword($this->old_password)) {
            $this->addError('old_password', Yii::t("app", "Current password incorrect"));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'status' => Yii::t('app', 'Status'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'passwordConfirm' => Yii::t('app', 'Password Confirm'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'login_ip' => Yii::t('app', 'Login Ip'),
            'login_time' => Yii::t('app', 'Login Time'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ban_time' => Yii::t('app', 'Ban Time'),
            'ban_reason' => Yii::t('app', 'Ban Reason'),
            'verifyCode' => Yii::t('app', 'Verify Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles() {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
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
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function getUserId($username) {
        $user_id = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return $user_id['id'];
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        $auth_key = $this->findOne(['id' => Yii::$app->user->id]);
        return $auth_key['auth_key'];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        $salt = $this->findOne(['id' => $this->getId()]);
        return Yii::$app->security->validatePassword($password . $salt['password_salt'], $this->password);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        // hash new password if set

        $salt = uniqid(Yii::$app->params['saltPrefix']) . time();
        if ($this->isNewRecord) {
            $this->password_salt = $salt;
            $this->password = Yii::$app->security->generatePasswordHash($this->password . $salt);
        }

        if (isset($this->new_password) && !empty($this->new_password)) {
            $this->password_salt = $salt;
            $this->password = Yii::$app->security->generatePasswordHash($this->new_password . $salt);
        }

        // convert ban_time checkbox to date
        if ($this->status == 1) {
            $this->ban_time = Yii::$app->jdate->date('Y-m-d H:i:s');
        } else {
            $this->status = 1;
        }

        if ($this->role_id == NULL) {
            $this->role_id = "user";
        }

        return parent::beforeSave($insert);
    }

    public function save_assignment($user_id, $item_name) {
        $assignment = new AuthAssignment();
        $find = $assignment->findAll(['user_id' => $user_id]);
        if ($find == TRUE) {
            $assignment->deleteAll(['user_id' => $user_id]);
        }

        $assignment->user_id = $user_id;
        $assignment->item_name = $item_name;
        $assignment->save();
    }

    /**
     * Update login info (ip and time)
     *
     * @return bool
     */
    public function updateLoginMeta() {
        // set data
        $this->auth_key = Helper::generateRandomString($this->username, $this->id);
        $this->login_ip = Yii::$app->getRequest()->getUserIP();
        $this->login_time = Yii::$app->jdate->date('Y-m-d H:i:s');

        // save and return
        return $this->save(false, ["auth_key", "login_ip", "login_time"]);
    }

}
