<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $image
 * @property string $authKey
 * @property string $accessToken
 * @property integer $pincode
 * @property integer $ipadress
 * @property string $perfectmoney
 * @property string $advancedcash
 * @property string $bitcoin
 * @property string $default_pay
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'email', 'password', 'authKey', 'accessToken', 'pincode', 'ipadress'], 'required'],
            [['pincode', 'ipadress'], 'integer'],
            [['default_pay'], 'string'],
            [['name', 'surname', 'username', 'email', 'password', 'image', 'authKey', 'accessToken', 'perfectmoney', 'advancedcash', 'bitcoin'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'image' => 'Image',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'pincode' => 'Pincode',
            'ipadress' => 'Ipadress',
            'perfectmoney' => 'Perfectmoney',
            'advancedcash' => 'Advancedcash',
            'bitcoin' => 'Bitcoin',
            'default_pay' => 'Default Pay',
        ];
    }
}
