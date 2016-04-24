<?php

namespace app\modules\dashbord\components;


/**
 * User component
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    public $identityClass = 'app\modules\Dashbord\models\User';

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = false;

    /**
     * @inheritdoc
     */
    public $loginUrl = ["/login"];

    public $authTimeout = 31557600;
    /**
     * @inheritdoc
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        /** @var \app\modules\user\models\User $identity */
        $identity->updateLoginMeta();
        parent::afterLogin($identity, $cookieBased, $duration);
    }

}
