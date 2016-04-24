<?php

namespace app\modules\Dashbord\models;

use Yii;

/**
 * This is the model class for table "{{%auth_item}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class Role extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName() {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren() {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0() {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    public function allRoles() {

        return [
            'post' => [
                ['name' => 'admin_post', 'label' => 'Admin Post', 'checked' => 0],
                ['name' => 'add_post', 'label' => 'Add Post', 'checked' => 0],
                ['name' => 'edit_post', 'label' => 'Edit Post', 'checked' => 0],
                ['name' => 'delete_post', 'label' => 'Delete Post', 'checked' => 0],
            ],
            'comment' => [
                ['name' => 'admin_comment', 'label' => 'Admin Comment', 'checked' => 0],
                ['name' => 'add_comment', 'label' => 'Add Comment', 'checked' => 0],
                ['name' => 'edit_comment', 'label' => 'Edit Comment', 'checked' => 0],
                ['name' => 'delete_comment', 'label' => 'Delete Comment', 'checked' => 0],
            ],
            'category' => [
                ['name' => 'admin_category', 'label' => 'Admin Category', 'checked' => 0],
                ['name' => 'add_category', 'label' => 'Add Category', 'checked' => 0],
                ['name' => 'edit_category', 'label' => 'Edit Category', 'checked' => 0],
                ['name' => 'delete_category', 'label' => 'Delete Category', 'checked' => 0],
            ],
            'user' => [
                ['name' => 'admin_user', 'label' => 'Admin User', 'checked' => 0],
                ['name' => 'add_user', 'label' => 'Add User', 'checked' => 0],
                ['name' => 'edit_user', 'label' => 'Edit User', 'checked' => 0],
                ['name' => 'delete_user', 'label' => 'Delete User', 'checked' => 0],
            ],
        ];
    }

    public function getAllRoles() {
        $roles = $this->allRoles();
        if (!$this->isNewRecord) {
            $db_all_roles = (new \yii\db\query())
                    ->select(['child'])
                    ->from('{{%auth_item_child}}')
                    ->where(['parent' => $this->name])
                    ->all();
            $db_roles = [];
            foreach ($db_all_roles as $key => $value) {
                array_push($db_roles, $value['child']);
            }

            foreach ($roles as $keyRole => $valueRole) {
                foreach ($valueRole as $keyItem => $item) {
                    if (in_array($item['name'], $db_roles)) {
                        $roles[$keyRole][$keyItem]['checked'] = 1;
                    }
                }
            }
        }
        return $roles;
    }

    public function save($runValidation = true, $attributeNames = null) {
        // parent::save($runValidation, $attributeNames);
        $auth = Yii::$app->authManager;
        $t = time();

        $sql = "DELETE FROM {{%auth_item_child}} WHERE `parent`='{$this->name}'";
        Yii::$app->db->createCommand($sql)->query();

        $items = Yii::$app->request->post('Items');
        $sql = "INSERT IGNORE INTO {{%auth_item}} (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) "
                . "VALUES ('{$this->name}', 1, '{$this->description}', NULL, NULL, $t, $t)";

        Yii::$app->db->createCommand($sql)->query();

        foreach ($items as $k => $v) {

            $sql = "INSERT IGNORE INTO {{%auth_item}} (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) "
                    . "VALUES ('{$k}', 2, '{$k}', NULL, NULL, $t, $t)";
            Yii::$app->db->createCommand($sql)->query();

            $sql = "INSERT INTO {{%auth_item_child}} (`parent`, `child`) VALUES ('{$this->name}', '{$k}')";
            Yii::$app->db->createCommand($sql)->query();
        }

        return true;
    }

    public function dropdown() {
        // get and cache data
        //[\yii\helpers\ArrayHelper::map(\app\modules\user\models\Role::findAll(['type'=>1]), 'name', 'name')]
        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::findAll(['type' => 1]);
            foreach ($models as $model) {
                $dropdown[$model->name] = $model->name;
            }
        }

        return $dropdown;
    }

}
