<?php

namespace app\models;

use app\models\fileuploads\FileUploads;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $userpic_id
 * @property string $authKey
 * @property integer $pincode
 * @property integer $ipadress
 * @property string $perfectmoney
 * @property string $advancedcash
 * @property string $bitcoin
 */

class User extends ActiveRecord implements IdentityInterface
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
            [['username', 'email', 'password'], 'required'],

            [['name', 'surname', 'username', 'email'], 'trim', 'on'=>'update-profile'],
            [['perfectmoney', 'advancedcash', 'bitcoin'], 'trim', 'on'=>'update-payments'],
            [['pincode', 'ipadress', 'userpic_id', 'default_pay'], 'integer'],

            [['name', 'surname', 'username', 'email', 'password', 'perfectmoney', 'advancedcash', 'bitcoin'], 'string', 'max' => 255],
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
            'username' => 'username',
            'email' => 'Email',
            'password' => 'Password',
            'userpic_id' => 'Userpic',
            'authKey' => 'Auth Key',
            'pincode' => 'Pincode',
            'ipadress' => 'Ipadress',
            'perfectmoney' => 'Perfectmoney',
            'advancedcash' => 'Advancedcash',
            'bitcoin' => 'Bitcoin',
        ];
    }
//    public $id;
//    public $username;
//    public $email;
//    public $password;
//    public $authKey;
//    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function getPaymentsList()
    {
        return [
            '0' => 'Advanced Cash',
            '1' => 'Perfect Money',
            '2' => 'Bitcoin',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function updateProfile()
    {
        return $this->save();
    }

    /**
     * Relation
     * @return \yii\db\ActiveQuery
     */
    public function getUserpic()
    {
        return $this->hasOne(FileUploads::className(), ['id' => 'userpic_id']);
    }

    public function getUserpicUrl($width=100, $height=100) {
        $url = $this->getDefaultUserpicUrl();
        if ($this->userpic) {
            $url = $this->userpic->getFileUrl();
        }

        $src = \app\helpers\ImageHelper::getPicture($url, $width, $height);

        return $src;
    }

    public function getDefaultUserpicUrl() {
        return 'no-image.png';
    }
}
