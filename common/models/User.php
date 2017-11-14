<?php
namespace common\models;

use common\models\fileuploads\FileUploads;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
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
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
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
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function updateProfile()
    {
        return $this->save();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
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

//        $src = ImageHelper::getPicture($url, $width, $height);

//        return $src;
    }

    public function getDefaultUserpicUrl() {
        return 'no-image.png';
    }
}
