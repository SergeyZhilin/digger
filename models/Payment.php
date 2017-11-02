<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $in_fr_deposit
 * @property integer $payin
 * @property string $time_payin
 * @property integer $payout
 * @property string $time_payout
 * @property integer $current_amount
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'in_fr_deposit', 'payin', 'time_payin', 'payout', 'time_payout', 'current_amount'], 'required'],
            [['user_id', 'in_fr_deposit', 'payin', 'payout', 'current_amount'], 'integer'],
            [['time_payin', 'time_payout'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'in_fr_deposit' => 'In Fr Deposit',
            'payin' => 'Payin',
            'time_payin' => 'Time Payin',
            'payout' => 'Payout',
            'time_payout' => 'Time Payout',
            'current_amount' => 'Current Amount',
        ];
    }
}
