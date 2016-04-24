<?php

namespace app\modules\Dashbord\models;

use Yii;

/**
 * This is the model class for table "{{%categorys}}".
 *
 * @property integer $id
 * @property string $group
 * @property string $category
 * @property string $item
 * @property integer $group_id
 * @property integer $category_id
 * @property string $shop_id
 * @property integer $user_id
 * @property integer $state
 */
class Categorys extends \yii\db\ActiveRecord {

    public static $GROUP_STATE = 1;
    public static $CATEGORY_STATE = 2;
    public static $ITEM_STATE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%categorys}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group', 'shop_id'], 'required', 'on' => 'group'],
            [['group_id', 'shop_id', 'category'], 'required', 'on' => 'category'],
            [['category_id', 'shop_id', 'item'], 'required', 'on' => 'item'],
            // [['group', 'category', 'item', 'group_id', 'category_id', 'shop_id', 'user_id'], 'required'],
            [['group_id', 'category_id', 'user_id', 'state'], 'integer'],
            [['group', 'category', 'item', 'shop_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'group' => Yii::t('app', 'Group'),
            'category' => Yii::t('app', 'Category'),
            'item' => Yii::t('app', 'Item'),
            'group_id' => Yii::t('app', 'Group ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'shop_id' => Yii::t('app', 'Shop ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function beforeSave($insert) {

        $this->user_id = Yii::$app->user->id;

        $post = Yii::$app->request->post('Categorys');
        if (isset($post['item'])) {
            $this->state = self::$ITEM_STATE;
        }
        if (isset($post['category'])) {
            $this->state = self::$CATEGORY_STATE;
        }

        if (isset($post['group'])) {
            $this->state = self::$GROUP_STATE;
        }

        return parent::beforeSave($insert);
    }

    /**
     * 
     * @staticvar type $dropdown
     * @return type
     * 
     */
    public static function GroupDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$GROUP_STATE])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->group;
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
    public static function CategoryDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$CATEGORY_STATE])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->category;
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
    public static function ItemDropdown() {

        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->where(['user_id' => yii::$app->user->id, 'state' => self::$ITEM_STATE])->all();
            $dropdown[] = '';
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->item;
            }
        }

        return $dropdown;
    }

}
