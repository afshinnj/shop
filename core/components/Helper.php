<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Helper extends Component {

    /**
     * 
     * @param type $Prefix
     * @return type
     * 
     */
    public static function generateRandomString($Prefix = NULL, $value = NULL) {
        if ($Prefix == NULL) {
            return md5($value.Yii::$app->security->generateRandomString() . time());
        } else {
            return $Prefix . md5($value.Yii::$app->security->generateRandomString() . time());
        }
    }

}
