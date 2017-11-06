<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class PasswordForm extends Model{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;

    public function rules(){
        return [
            [['oldpass','newpass','repeatnewpass'],'required'],
            ['oldpass','findPasswords'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }

    public function findPasswords($attribute, $params){
        $user = User::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();

        $password = $user->password;
        if (Yii::$app->getSecurity()->validatePassword($this->oldpass, $password)) {
            // all good, logging user in
        } else {
            $this->addError($attribute,'Old password is incorrect');
        }
    }

    public function attributeLabels(){
        return [
            'oldpass'=>'Старый Пароль',
            'newpass'=>'Новый Пароль',
            'repeatnewpass'=>'Повторите Новый Пароль',
        ];
    }
}