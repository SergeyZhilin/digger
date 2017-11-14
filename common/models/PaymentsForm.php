<?php
namespace common\models;

use Yii;
use yii\base\Model;

class PaymentsForm extends Model{
    public $advancedcash;
    public $perfectmoney;
    public $bitcoin;
    public $default_pay;

    public function rules(){
        return [
            ['advancedcash', 'trim'],
            ['perfectmoney', 'trim'],
            ['bitcoin', 'trim'],
        ];
    }

    public function attributeLabels(){
        return [
            'advancedcash'  =>  'Advanced Cash',
            'perfectmoney'  =>  'Perfect Money',
            'bitcoin'       =>  'Bitcoin',
            'default_pay'       =>  'Default',
        ];
    }

    public function save() {
        $this->perfectmoney = $_POST['PaymentsForm']['perfectmoney'];
        $this->advancedcash = $_POST['PaymentsForm']['advancedcash'];
        $this->bitcoin = $_POST['PaymentsForm']['bitcoin'];
        $this->default_pay = $_POST['PaymentsForm']['default_pay'];
        return true;
    }
}