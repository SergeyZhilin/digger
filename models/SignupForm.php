<?php


namespace app\models;

use Yii;
use yii\base\Model;



class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
//    public $userstatus = "user";
//    private $fuser = false;


    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required','message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Этот емейл уже занят'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'email' => 'Емейл',
            'password' => 'Пароль',
        ];
    }

}