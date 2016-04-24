<?php

namespace app\modules\Shop\models;

use Yii;

/**
 * This is the model class for table "{{%details}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $item
 * @property string $value
 * @property integer $title_id
 * @property integer $item_id
 * @property integer $user_id
 * @property string $shop_id
 * @property integer $state
 */
class Details extends \yii\db\ActiveRecord
{
    
    public static $DETAIL = 1;
    
    public static $ITEM = 2;
    
    public static $VALUE = 3;

        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%details}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['title', 'item', 'value', 'title_id', 'item_id', 'user_id', 'shop_id'], 'required'],
            [['title', 'shop_id'], 'required', 'on'=>'create'],
            [['title_id', 'shop_id','item'], 'required', 'on'=>'ItemCreate'],
            [['title_id', 'item_id', 'user_id'], 'integer'],
            [['title', 'item', 'value', 'shop_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'item' => Yii::t('app', 'Item'),
            'value' => Yii::t('app', 'Value'),
            'title_id' => Yii::t('app', 'Title ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'shop_id' => Yii::t('app', 'Shop ID'),
        ];
    }
    
    public function beforeSave($insert) {
        $this->user_id = Yii::$app->user->id;
        
        $post = Yii::$app->request->post('Details');
        if(isset($post['title'])){
            $this->state = self::$DETAIL;
        }
        
        if(isset($post['item'])){
            $this->state = self::$ITEM;
        }
        
        if(isset($post['value'])){
            $this->state = self::$VALUE;
        }
        
        return parent::beforeSave($insert);
    }
    
    
        /**
     * 
     * @staticvar type $dropdown
     * @return type
     * 
     */
    public static function TitleDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$DETAIL])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->title;
            }
        }

        return $dropdown;
    }

    /**
     * 
     * @staticvar type $dropdown
     * @return type
     * 
     */
    public static function itemDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$ITEM])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->item;
            }
        }

        return $dropdown;
    }

    /**
     * 
     * @staticvar type $dropdown
     * @return type
     * 
     */
    public static function valueDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$ITEM])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->value;
            }
        }

        return $dropdown;
    }
}
