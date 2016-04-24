<?php

namespace app\modules\user\components;

use Yii;
use yii\base\Component;
use app\modules\User\models\User;

class UserHelper extends Component {


    public static function validateAuthKey($auth_key = NULL) {
        $key = User::findOne(['id'=>Yii::$app->user->id]);
        if($key['auth_key']===$auth_key){
            return TRUE;
        }
        
    }

}
