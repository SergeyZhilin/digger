<?php

namespace common\models\fileuploads;

use Yii;
use yii\db\Expression;
use yii\web\HttpException;
use yii\db\Exception;
use app\helpers\ImageHelper;

/**
 * This is the model class for table "file_uploads".
 *
 * @property string $id
 * @property string $session_id
 * @property string $secret
 * @property string $file_type
 * @property string $file_path_tmp
 * @property string $file_path
 * @property string $file_name
 * @property string $file_extention
 * @property string $file_realname
 * @property string $image_dimensions
 * @property string $image_crop
 * @property string $image_crop_ratio
 * @property string $video_snapshot_name
 * @property string $media_duration
 * @property string $upload_date
 * @property integer $is_approved
 * @property string $date_updated
 */
class FileUploads extends \yii\db\ActiveRecord
{
    const TMP_FILE_PATH = '/web/uploads/temp/'; // path for temporary upload files. For ex.: /uploads
    const TMP_FILE_LIFE_TIME = 30; // minutes after temp files will be removed
    const MAX_IMAGE_WIDTH = 2000; // image will be resized for this width if its more. set 0 if image width unlimit
    const MAX_IMAGE_HEIGHT = 2000; // image will be resized for this height if its more. set 0 if image height unlimit
    const FILE_TYPE_UNKNOWN = 0;
    const FILE_TYPE_IMAGE = 1;
    const FILE_TYPE_VIDEO = 2;
    const FILE_TYPE_AUDIO = 3;
    const FILE_TYPE_TEXT = 4;

    private static $globalUploadSettins = [];

    public static $extensions_arr = [
        self::FILE_TYPE_IMAGE => ['png', 'jpg', 'jpeg', 'gif'],
        self::FILE_TYPE_VIDEO => ['avi', 'mpg', 'mpeg', 'flv'],
        self::FILE_TYPE_AUDIO => ['mp3', 'vaw'],
        self::FILE_TYPE_TEXT => ['txt', 'doc', 'rtf'],
    ];

    public static function uploadSettings($upload_name) {
        $settings = [
            'userpic' => [
                'uploadPath' => '/web/uploads/images/',
                'uploadType' => 'userpic',
                'sizeLimit' => 5242880,    // 5Mb
                'imageMinWidth' => 50,
                'imageMinHeight' => 50,
                'imageMaxWidth' => 2000,
                'imageMaxHeight' => 2000,
                'allowedExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
            ],
        ];

        return \yii\helpers\ArrayHelper::merge(self::$globalUploadSettins, $settings[$upload_name]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_uploads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_id', 'secret', 'file_path', 'file_name', 'file_extention', 'file_realname'], 'required'],
            [['file_type', 'media_duration', 'is_approved'], 'integer'],
            [['upload_date', 'date_updated'], 'safe'],
            [['session_id', 'file_path_tmp', 'file_path', 'file_name', 'file_realname'], 'string', 'max' => 255],
            [['secret', 'image_crop_ratio'], 'string', 'max' => 500],
            [['file_extention'], 'string', 'max' => 4],
            [['image_dimensions'], 'string', 'max' => 20],
            [['image_crop'], 'string', 'max' => 1000],
            [['video_snapshot_name'], 'string', 'max' => 100],

            [['file_path'], 'required', 'on' => 'upload-save'],
            [['file_path_tmp'], 'required', 'on' => 'upload-tmp'],
        ];
    }

    public function scenarios()
    {
        return [
            'upload-save' => ['file_path'],
            'upload-tmp' => ['file_path_tmp'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'secret' => 'Secret',
            'file_type' => 'File Type',
            'file_path_tmp' => 'File Path Tmp',
            'file_path' => 'File Path',
            'file_name' => 'File Name',
            'file_extention' => 'File Extention',
            'file_realname' => 'File Realname',
            'image_dimensions' => 'Image Dimensions',
            'image_crop' => 'Image Crop',
            'image_crop_ratio' => 'Image Crop Ratio',
            'video_snapshot_name' => 'Video Snapshot Name',
            'media_duration' => 'Media Duration',
            'upload_date' => 'Upload Date',
            'is_approved' => 'Is Approved',
            'date_updated' => 'Date Updated',
        ];
    }

    public function beforeDelete() {
        if (!parent::beforeDelete())
            return false;

        if (strlen($this->file_path_tmp) > 0) {
            $temp_file = Yii::getAlias('@root') . $this->file_path_tmp . $this->file_name . '.' . $this->file_extention;
            if (file_exists($temp_file) && !is_dir($temp_file))
                unlink($temp_file);
        }

        if (strlen($this->file_path) > 0) {
            $file = Yii::getAlias('@root') . $this->file_path . $this->file_name . '.' . $this->file_extention;
            if (file_exists($file) && !is_dir($file))
                unlink($file);
        }

        if ($this->file_type == self::FILE_TYPE_VIDEO) {
            $file_path = ($this->is_approved == 1) ? $this->file_path : $this->file_path_tmp;
            $snapshot = Yii::getAlias('@root') . $file_path . $this->video_snapshot_name . '.jpg';
            if (file_exists($snapshot) && !is_dir($snapshot))
                unlink($snapshot);

            if ($this->file_extention != 'flv') {
                $flv_file = Yii::getAlias('@root');
                $flv_file .= ($this->is_approved == 1) ? $this->file_path : $this->file_path_tmp;
                $flv_file .= $this->file_name . '.flv';
                if (file_exists($flv_file) && !is_dir($flv_file))
                    unlink($flv_file);
            }
        }

        return true;
    }

    public static function loadFile($file_id) {
        $file = self::findOne($file_id);
        return $file;
    }

    public function getFileUrl($params = []) {
        if (!isset($params['crop_image']))
            $params['crop_image'] = true;
        if (!isset($params['flv_video']))
            $params['flv_video'] = true;

        if ($this->is_approved == 1)
            $url = $this->file_path . $this->file_name . '.' . $this->file_extention;
        else
            $url = $this->file_path_tmp . $this->file_name . '.' . $this->file_extention;

        if ($this->file_type == self::FILE_TYPE_IMAGE && $params['crop_image'] === true) {
            if ($this->isImageNeedCrop()) {
                $image_crop = $this->getImageCrop();
                $url = ImageHelper::crop($image_crop['x'], $image_crop['y'], $image_crop['x1'] - $image_crop['x'], $image_crop['y1'] - $image_crop['y'], $url);
            }
        }

        if ($this->file_type == self::FILE_TYPE_VIDEO && $params['flv_video']) {
            $url = $this->getVideoFlvUrl();
        }

        return $url;
    }

    public static function autoClearTmpFiles() {
        $remove_time = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - self::TMP_FILE_LIFE_TIME * 60);
        $delFiles = self::find()->where(['and', ['!=', 'is_approved', 1], ['<', 'upload_date', $remove_time]])->all();
        foreach ($delFiles as $file) {
            $file->delete();
        }
    }

    public function deleteFile() {
        $this->delete();
    }

    public function saveTmpFile() {
        $file_name = md5(time() . rand(0, 1000));
        $this->scenario = 'upload-tmp';
        $this->file_type = self::getFileType(strtolower($this->file_extention));
        $this->file_path_tmp = self::TMP_FILE_PATH;
        $this->file_extention = strtolower($this->file_extention);
        $this->is_approved = 0;
        $this->upload_date = new Expression('NOW()');
        $this->file_name = $file_name;
        $this->session_id = session_id();
        $this->secret = $file_name;

        if (!is_dir(Yii::getAlias('@root') . self::TMP_FILE_PATH)) {
            mkdir(Yii::getAlias('@root') . self::TMP_FILE_PATH, 0777, true);
        }

        if (is_dir(Yii::getAlias('@root') . self::TMP_FILE_PATH)) {
            if ($this->save()) {
                self::autoClearTmpFiles();

                return $this;
            }
        }
        return false;
    }

    public function saveFile($is_create_dir = false) {
        if ($this->is_approved == 1)
            return true;

        $temp_file = Yii::getAlias('@root') . $this->file_path_tmp . $this->file_name . '.' . $this->file_extention;
        $file_path = Yii::getAlias('@root') . $this->file_path;
        $file = Yii::getAlias('@root') . $this->file_path . $this->file_name . '.' . $this->file_extention;
        if ($this->file_type == self::FILE_TYPE_VIDEO) {
            $temp_snapshot = Yii::getAlias('@root') . $this->file_path_tmp . $this->video_snapshot_name . '.jpg';
            $temp_flv = Yii::getAlias('@root') . $this->file_path_tmp . $this->file_name . '.flv';
        }

        $transaction = $this->db->beginTransaction();
        try {
            $this->scenario = 'upload-save';
            $this->is_approved = 1;
            $this->file_path_tmp = '';
            $this->upload_date = new Expression('NOW()');

            if ($this->save()) {
                if (!file_exists($temp_file))
                    throw new HttpException(500, 'Upload temp file is not exists.');

                if (!is_dir($file_path)) {
                    if ($is_create_dir) {
                        if (!mkdir($file_path, 0777, true))
                            throw new HttpException(500, 'Cannot create directory for upload file.');
                    } else
                        throw new HttpException(500, 'Directory for upload files is not exists.');
                }

                if (!rename($temp_file, $file))
                    throw new HttpException(500, 'Cannot remove upload temp file.');

                if (!file_exists($file))
                    throw new HttpException(500, 'Cannot remove upload temp file.');

                if ($this->file_type == self::FILE_TYPE_VIDEO) {
                    if (isset($temp_snapshot) && file_exists($temp_snapshot) && !is_dir($temp_snapshot))
                        unlink($temp_snapshot);

                    if (isset($temp_flv) && file_exists($temp_flv) && !is_dir($temp_flv))
                        unlink($temp_flv);
                }

                $transaction->commit();
                return true;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            var_dump($e);
            exit;
        }

        return false;
    }

    public function getFileInfo($params = []) {
        if (!isset($params['crop_image']))
            $params['crop_image'] = true;

        $info_arr = [
            'file_size' => 0,
        ];

        $file = Yii::getAlias('@root') . $this->getFileUrl(['crop_image' => $params['crop_image']]);
        if (!file_exists($file))
            return $info_arr;

        $info_arr['file_size'] = filesize($file);

        return $info_arr;
    }

    public function copyFile() {
        $copy = new self(['scenario'=>'upload-save']);
        $copy->session_id = session_id();
        $copy->file_type = $this->file_type;
        $copy->file_name = md5(time() . rand(0, 1000));
        $copy->file_realname = $this->file_realname;
        $copy->secret = $copy->file_name;
        $copy->file_path = $this->file_path;
        $copy->file_extention = $this->file_extention;
        $copy->image_dimensions = $this->image_dimensions;
        $copy->image_crop = $this->image_crop;
        $copy->image_crop_ratio = $this->image_crop_ratio;
        $copy->media_duration = $this->media_duration;
        $copy->is_approved = 1;

        $transaction = $this->db->beginTransaction();
        try {
            if ($copy->save(false)) {
                $srcPath = Yii::getAlias('@root') . $this->file_path . $this->file_name . '.' . $this->file_extention;
                $dstPath = Yii::getAlias('@root') . $copy->file_path . $copy->file_name . '.' . $copy->file_extention;
                if (!copy($srcPath, $dstPath)) {
                    throw new HttpException(500, 'Cannot copy file.');
                }
                $transaction->commit();
                return $copy;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public static function getFileType($ext) {
        if (in_array($ext, self::$extensions_arr[self::FILE_TYPE_IMAGE]))
            return self::FILE_TYPE_IMAGE;

        if (in_array($ext, self::$extensions_arr[self::FILE_TYPE_VIDEO]))
            return self::FILE_TYPE_VIDEO;

        if (in_array($ext, self::$extensions_arr[self::FILE_TYPE_AUDIO]))
            return self::FILE_TYPE_AUDIO;

        if (in_array($ext, self::$extensions_arr[self::FILE_TYPE_TEXT]))
            return self::FILE_TYPE_TEXT;

        return self::FILE_TYPE_UNKNOWN;
    }

    public function getImageDimensions() {
        $image_dimensions_arr = ['width' => 0, 'height' => 0];

        $image_dimensions = explode(',', $this->image_dimensions);
        if (is_array($image_dimensions) && count($image_dimensions) == 2) {
            $image_dimensions_arr['width'] = $image_dimensions[0];
            $image_dimensions_arr['height'] = $image_dimensions[1];
        } else {
            $real_image_src = $this->getFileUrl(['crop_image' => false]);
            if (strlen($real_image_src) > 0 && file_exists(Yii::getAlias('@root') . $real_image_src)) {
                $real_image_info = getimagesize(Yii::getAlias('@root') . $real_image_src);
                $image_dimensions_arr['width'] = $real_image_info[0];
                $image_dimensions_arr['height'] = $real_image_info[1];

                $this->image_dimensions = implode(',', $image_dimensions_arr);
                $this->save(false, ['image_dimensions']);
            }
        }

        return $image_dimensions_arr;
    }

    public function setImageCropRatio($width, $height) {
        if ($this->file_type == self::FILE_TYPE_IMAGE) {
            if ($width > 0 && $height > 0) {
                $ratio = $width / $height;
                $dimensions = $this->getImageDimensions();
                if ($width > $dimensions['width']) {
                    $width = $dimensions['width'];
                    $height = $width * $ratio;
                }
                if ($height > $dimensions['height']) {
                    $height = $dimensions['height'];
                    $width = $height * $ratio;
                }

                $this->image_crop_ratio = $width . ',' . $height;
                $this->save(false, ['image_crop_ratio']);
            }
        }
    }

    public function getImageCropRatio($image_width = null) {
        $image_crop_ratio = ['width' => 0, 'height' => 0, 'ratio' => 0];
        if ($this->file_type == self::FILE_TYPE_IMAGE) {
            if (strlen($this->image_crop_ratio) > 0) {
                list($width, $height) = explode(',', $this->image_crop_ratio);
                if ($width > 0 && $height > 0) {
                    $real_image_dimensions = $this->getImageDimensions();
                    $ratio = ($image_width) ? $image_width / $real_image_dimensions['width'] : 1;

                    $image_crop_ratio = [
                        'width' => $width * $ratio,
                        'height' => $height * $ratio,
                        'ratio' => $width / $height
                    ];
                }
            }
        }
        return $image_crop_ratio;
    }

    public function getImageCrop($image_width = null) {
        $real_image_src = $this->getFileUrl(['crop_image' => false]);
        if (strlen($real_image_src) > 0 && file_exists(Yii::getAlias('@root') . $real_image_src)) {
            $image_crop = (@unserialize($this->image_crop)) ? unserialize($this->image_crop) : [];

            $image_crop_ratio = $this->getImageCropRatio($image_width);

            if (!isset($image_crop['x']))
                $image_crop['x'] = 0;
            if (!isset($image_crop['y']))
                $image_crop['y'] = 0;
            if (!isset($image_crop['x1']))
                $image_crop['x1'] = 0;
            if (!isset($image_crop['y1']))
                $image_crop['y1'] = 0;

            $real_image_dimensions = $this->getImageDimensions();
            $ratio = ($image_width) ? $image_width / $real_image_dimensions['width'] : 1;

            // if selection exists
            if ($image_crop['x'] != $image_crop['x1'] && $image_crop['y'] != $image_crop['y1']) {
                $image_crop['x'] *= $ratio;
                $image_crop['y'] *= $ratio;
                $image_crop['x1'] *= $ratio;
                $image_crop['y1'] *= $ratio;
            } else {
                $image_crop['x'] = 0;
                $image_crop['y'] = 0;
                $image_crop['x1'] = $real_image_dimensions['width'] * $ratio;
                $image_crop['y1'] = $real_image_dimensions['height'] * $ratio;
                if ($image_crop_ratio['ratio'] != 0) {
                    $x1 = $image_crop['x1'];
                    $y1 = $image_crop['y'] + ($image_crop['x1'] - $image_crop['x']) * $image_crop_ratio['ratio'];
                    if ($y1 > $real_image_dimensions['height'] * $ratio) {
                        $y1 = $image_crop['y1'];
                        $x1 = $image_crop['x'] + ($image_crop['y1'] - $image_crop['y']) * $image_crop_ratio['ratio'];
                    }
                    $image_crop['x1'] = $x1;
                    $image_crop['y1'] = $y1;
                }
            }

            return $image_crop;
        }

        return null;
    }

    public function isImageNeedCrop() {
        $image_crop = $this->getImageCrop();
        $real_image_dimensions = $this->getImageDimensions();
        if ($image_crop) {
            if ($image_crop['x1'] > 0 && $image_crop['y1'] > 0 && $image_crop['x1'] <= $real_image_dimensions['width'] && $image_crop['y1'] <= $real_image_dimensions['height'])
                return true;
        }

        return false;
    }

    /**
     * @param array $coords - if $coords=null than takes all image
     * @param null $image_width
     * @return bool
     */
    public function saveImageCrop($coords = null, $image_width = null) {
        if ($this->file_type != self::FILE_TYPE_IMAGE)
            return false;

        $real_image_src = $this->getFileUrl(['crop_image' => false]);
        if (strlen($real_image_src) > 0 && file_exists(Yii::getAlias('@root') . $real_image_src)) {
            $real_image_dimensions = $this->getImageDimensions();

            $image_crop_ratio = $this->getImageCropRatio($image_width);

            if (!is_array($coords) || count($coords) != 4) {
                $coords_arr = [];
                $coords_arr['x'] = 0;
                $coords_arr['y'] = 0;
                $coords_arr['x1'] = $real_image_dimensions['width'];

                $y1 = $real_image_dimensions['height'];
                if ($image_crop_ratio['ratio'] != 0) {
                    $y1 = $real_image_dimensions['width'] * $image_crop_ratio['ratio'];
                    if ($y1 > $real_image_dimensions['height']) {
                        $y1 = $real_image_dimensions['height'];
                        $coords_arr['x1'] = $coords_arr['x'] + ($coords_arr['y'] * $image_crop_ratio['ratio']);
                    }
                }
                $coords_arr['y1'] = $y1;
            } else {
                $coords_arr['x'] = $coords[0];
                $coords_arr['y'] = $coords[1];
                $coords_arr['x1'] = $coords[2];
                $coords_arr['y1'] = $coords[3];

                if ($coords_arr['x'] >= $coords_arr['x1'] || $coords_arr['y'] >= $coords_arr['y1'])
                    return false;

                if ($image_width) {
                    $ratio = $real_image_dimensions['width'] / $image_width;

                    $coords_arr['x'] *= $ratio;
                    $coords_arr['y'] *= $ratio;
                    $coords_arr['x1'] *= $ratio;
                    $coords_arr['y1'] *= $ratio;


                    $coords_arr['x'] = max(0, min($coords_arr['x'], $real_image_dimensions['width']));
                    $coords_arr['y'] = max(0, min($coords_arr['y'], $real_image_dimensions['height']));
                    $coords_arr['x1'] = max(0, min($coords_arr['x1'], $real_image_dimensions['width']));
                    $coords_arr['y1'] = max(0, min($coords_arr['y1'], $real_image_dimensions['height']));
                }
            }

            $this->image_crop = serialize($coords_arr);
            return $this->save(false, ['image_crop']);
        }

        return false;
    }

    public function getVideoSnapshotUrl() {
        // save video file thumbnail
        if ($this->file_type == self::FILE_TYPE_VIDEO) {
            $file_path = ($this->is_approved == 1) ? $this->file_path : $this->file_path_tmp;
            $snapshot = $file_path . $this->video_snapshot_name . '.jpg';

            if (!file_exists(Yii::getAlias('@root') . $snapshot)) {
                if (Yii::$app->ffmpeg) {
                    $video_url = Yii::getAlias('@root') . $this->getFileUrl();

                    if ($this->is_approved == 1)
                        $snaphot_path = Yii::getAlias('@root') . $this->file_path;
                    else
                        $snaphot_path = Yii::getAlias('@root') . $this->file_path_tmp;

                    $snapshot_name = md5(time() . rand(0, 1000));
                    $success = Yii::app()->ffmpeg->getSnapshot($video_url, $snaphot_path, $snapshot_name);
                    if ($success) {
                        $this->video_snapshot_name = $snapshot_name;
                        $this->save(false, ['video_snapshot_name']);
                    }
                } else throw new HttpException(500, 'FFMpeg component for video snapshot is not found.');
            }

            $snapshot = $file_path . $this->video_snapshot_name . '.jpg';
            if (file_exists(Yii::getAlias('@root') . $snapshot) && !is_dir(Yii::getAlias('@root') . $snapshot))
                return $snapshot;
        }

        return null;
    }

    public function getVideoFlvUrl() {
        if ($this->file_type == self::FILE_TYPE_VIDEO) {
            $flv_file = ($this->is_approved == 1) ? $this->file_path : $this->file_path_tmp;
            $flv_file .= $this->file_name . '.flv';

            if (!file_exists(Yii::getAlias('@root') . $flv_file)) {
                $video_url = Yii::getAlias('@root') . $this->getFileUrl(['flv_video' => false]);

                $success = (Yii::$app->ffmpeg) ? Yii::$app->ffmpeg->convertToFlv($video_url, Yii::getAlias('@root') . $flv_file) : null;
                if ($success) {
                    return $flv_file;
                }
            } else
                return $flv_file;

            return null;
        }
    }

    public function getMediaDuration() {
        if (in_array($this->file_type, [self::FILE_TYPE_VIDEO, self::FILE_TYPE_AUDIO])) {
            if ($this->media_duration > 0)
                return $this->media_duration;
            else {
                $media_url = Yii::getAlias('@root') . $this->getFileUrl(['flv_video' => false]);
                $duration = (Yii::$app->ffmpeg) ? (int) Yii::$app->ffmpeg->getDuration($media_url) : 0;

                if ($duration > 0) {
                    $this->media_duration = $duration;
                    $this->save(false, ['media_duration']);
                }

                return $duration;
            }
        }

        return 0;
    }
}
