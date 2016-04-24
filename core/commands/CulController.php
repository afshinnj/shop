<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class CulController extends Controller {

    public function actionInit($num = null, $num2 = null) {
        echo $num + $num2 . "\n";
    }

    public function actionUser() {


    }

}
