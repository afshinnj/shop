<?php

namespace app\modules\Shop\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%shop}}".
 *
 * @property integer $id
 * @property string $shop_id
 * @property integer $user_id
 * @property string $title
 * @property string $name
 * @property string $email
 * @property string $tel
 * @property string $description
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $ban_time
 * @property string $ban_reason
 */
class Shop extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'unique'],
            [['email'], 'email'],
            [['tel'], 'number'],
            [['title', 'email', 'tel', 'description', 'name'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'update_time', 'ban_time'], 'safe'],
            [['shop_id', 'title', 'email', 'tel', 'ban_reason'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'shop_id' => Yii::t('app', 'Shop ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'tel' => Yii::t('app', 'Tel'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ban_time' => Yii::t('app', 'Ban Time'),
            'ban_reason' => Yii::t('app', 'Ban Reason'),
        ];
    }

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
    public function beforeSave($insert) {
        // hash new password if set
        if ($this->isNewRecord) {
            $this->user_id = Yii::$app->user->id;
            $this->shop_id = '#' . md5($this->user_id . time() . Yii::$app->security->generateRandomString());
        }

        return parent::beforeSave($insert);
    }

    /**
     * 
     * @staticvar type $dropdown
     * @return type
     * 
     */
    public static function Dropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::findAll(['user_id' => Yii::$app->user->id]);
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->shop_id] = $model->name;
            }
        }

        return $dropdown;
    }

}
