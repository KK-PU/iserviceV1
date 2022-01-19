<?php
namespace app\components;
use Yii;
use yii\base\BootstrapInterface;

class IdentitySwitcher implements BootstrapInterface
{
    public function bootstrap($app)
    {
        //we set this in parentLogin action
        //so if we loggin in as a parent user it will be true
        if ($app->session->get('isUser')) {
            $app->user->identityClass = 'app\models\Employee';
        }
    }
}
?>
