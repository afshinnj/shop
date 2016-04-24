<?php

namespace app\modules\Dashbord;

use Yii;
use app\modules\Dashbord\models\User;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\Dashbord\controllers';
    public $layout = "@app/modules/views/layouts/frontend.php";
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * 
     * @return type
     * 
     */
    public static function getAuthKey() {
        $AuthKey = Yii::$app->user->identity;
        return $AuthKey['auth_key'];
    }

    /**
     * 
     * @param type $auth_key
     * @return boolean
     */
    public static function validateAuthKey($auth_key = NULL) {
        $key = User::findOne(['id' => Yii::$app->user->id]);

        if ($key['auth_key'] === $auth_key) {
            return TRUE;
        }
    }

    /**
     * 
     * @return type
     * 
     */
    public static function getUserId() {
        $a = Yii::$app->user->identity;
        return $a['id'];
    }

}
