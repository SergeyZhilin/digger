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
            ['username', 'trim'],
            [['username', 'email', 'password'], 'required','message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Этот емейл уже занят'],
            ['password', 'string', 'min' => 6],
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