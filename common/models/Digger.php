<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "digger".
 *
 * @property integer $id
 * @property integer $bit_price
 */
class Digger extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'digger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bit_price'], 'required'],
            [['bit_price'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bit_price' => 'Bit Price',
        ];
    }
}
