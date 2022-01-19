<?php
namespace app\components;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\Cookie;
use yii\base\Exception;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        $cookies = Yii::$app->response->cookies;

        $languageNew = Yii::$app->request->get('language');

        if($languageNew !== null)
        {
            if (!in_array($languageNew, $this->supportedLanguages)) { 
                throw new Exception('Invalid your selected language.');
            }
                $cookies->add(new Cookie([
                    'name' => 'language',
                    'value' => $languageNew,
                    'expire' => time() + 60 * 60 * 24 * 60,
                ]));

                \Yii::$app->language = $languageNew;
        }
        else
        {

            $preferedLanguage = isset(Yii::$app->request->cookies['language']) ? (string) Yii::$app->request->cookies['language'] : 'th';

            if(empty($preferedLanguage))
            {
                $preferedLanguage = Yii::$app->request->getPreferedLanguage($this->supportedLanguages); 
            }

           \Yii::$app->language =  $preferedLanguage;
        }
    }
}
