<?php

namespace app\controllers;

use yii\web\Controller;


class MainController extends Controller
{
    /**
     *
     */
    public $users;
    public $user_id;
    public $username;
    public $payin = 0;
    public $payout = 0;
    public $in_fr_deposit = 0;
    public $bit_price_in;
    public $bit_price_out;
    public $bit_price_dep;
    public $bit_prices;
    public $payments;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
        {
            return false;
        }

        $this->users = \app\models\User::findIdentity(\Yii::$app->user->id);
        if (isset($this->users)){
            $this->user_id = $this->users->id;
            $this->username = $this->users->username;
        }
        $this->bit_prices = \app\models\Digger::findOne(1);


        $this->payments = \app\models\Payment::find()->where('user_id = :user_id', [':user_id' => $this->user_id])->all();

        if (isset($this->payments)){

            foreach ($this->payments as $payment){

                $this->payin += $payment->payin;
                $this->payout += $payment->payout;
                $this->in_fr_deposit += $payment->in_fr_deposit;
            }

            $this->bit_price_in = round($this->payin / $this->bit_prices->bit_price, 2);
            $this->bit_price_out = round($this->payout / $this->bit_prices->bit_price, 2);
            $this->bit_price_dep = round($this->in_fr_deposit / $this->bit_prices->bit_price, 2);

        }
        return true;
    }

}