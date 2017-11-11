<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ProfileForm extends Model{
    public $name;
    public $surname;
    public $username;
    public $email;
    /**
     * @var UploadedFile
     */
    public $image;


    public function rules(){
        return [
            [['name', 'surname', 'username', 'email'], 'trim'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['image'], 'upload']
        ];
    }

    public function attributeLabels(){
        return [
            'name'  =>  'Ваше Имя: ',
            'surname'  =>  'Ваша Фамилия: ',
            'username'  =>  'Ваш Логин: ',
            'email'  =>  'Адрес електронной почты: ',
            'image'  =>  'Выберите фотографию: ',
        ];
    }

    public function upload()
    {
        var_dump($this->image); die();
        //$this->image = UploadedFile::getInstance($this, 'image');

        if (isset($this->image) && !empty($this->image)){

            $path = ('uploads/' . $this->image->baseName . '.' . $this->image->extension);
//            $imgname = uniqid($this->image->baseName);
//            $path = ('uploads/' . $imgname . '.' . $this->image->extension);

            $this->image->saveAs($path);


            return true;
        } else {
            $this->addError('image', 'something went wrong');
        }
    }

    public function save()
        {
                $this->name = $_POST['ProfileForm']['name'];
                $this->surname = $_POST['ProfileForm']['surname'];
                $this->username = $_POST['ProfileForm']['username'];
                $this->email = $_POST['ProfileForm']['email'];
//                $this->image = $this->image->baseName;
                return true;
        }
}