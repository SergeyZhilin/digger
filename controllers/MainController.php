<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;


class MainController extends Controller
{
    /**
     *
     */
    public $users;
    public $user_id;
    public $image;
    public $username;
    public $payin = 0;
    public $payout = 0;
    public $in_fr_deposit = 0;
    public $bit_price_in;
    public $bit_price_out;
    public $bit_price_dep;
    public $bit_prices;
    public $payments;
    public $path;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
        {
            return false;
        }

        if(Yii::$app->user->isGuest && !in_array($this->id, ['site'])) {
            $this->redirect('/site/login');
        }

        $this->users = \app\models\User::findIdentity(\Yii::$app->user->id);

        return true;
    }

}