<?php

namespace app\modules\Frontend;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\Frontend\controllers';
    public $layout = "@app/modules/views/layouts/frontend.php";

    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
