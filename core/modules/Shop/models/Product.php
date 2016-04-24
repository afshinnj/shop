<?php

namespace app\modules\Shop\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $shop_id
 * @property integer $item_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $detail
 * @property string $price
 * @property string $create_time
 * @property string $update_time
 */
class Product extends ActiveRecord
{
    
    public $category_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','description'], 'required'],
            [['item_id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['shop_id', 'title', 'detail','price'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shop_id' => Yii::t('app', 'Shop ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'detail' => Yii::t('app', 'Detail'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
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
    
    public function beforeSave($insert) {
        $this->user_id = Yii::$app->user->id;
        
        
        return parent::beforeSave($insert);
    }
}
