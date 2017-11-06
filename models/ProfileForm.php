<?php
namespace app\models;

use yii\base\Model;

class ProfileForm extends Model{
    public $name;
    public $surname;
    public $username;
    public $email;

    public function rules(){
        return [
            ['name', 'trim'],
            ['surname', 'trim'],
            ['username', 'trim'],
            ['email', 'trim'],
        ];
    }

    public function attributeLabels(){
        return [
            'name'  =>  'Ваше Имя: ',
            'surname'  =>  'Ваша Фамилия: ',
            'username'  =>  'Ваш Логин: ',
            'email'  =>  'Адрес електронной почты: ',
        ];
    }
}