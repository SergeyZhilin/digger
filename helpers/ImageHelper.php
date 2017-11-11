<?php
namespace app\helpers;

use Yii;
use app\models\fileuploads\FileUploads;
use app\helpers\FileHelper;
use PhpThumbFactory;

class ImageHelper {

    /**
     * Directory to store thumbnails
     * @var string
     */

    const ORIGINAL_MAX_WIDTH = 0;  // 0 - unlimited
    const ORIGINAL_MAX_HEIGHT = 0;  // 0 - unlimited

    public static function getThumbDir()
    {
        return Yii::getAlias('@root').FileUploads::TMP_FILE_PATH.'thumbs/';
    }


    /**
     * Create a thumbnail of an image and returns relative path in webroot
     * the options array is an associative array which can take the values
     * quality (jpg quality) and method (the method for resizing)
     *
     * @param int $width
     * @param int $height
     * @param string $img
     * @param array $options
     * @return string $path
     */
    public static function thumb($width, $height, $img, $options = null)
    {
        if(!file_exists($img)){
            $img = str_replace('\\', '/', Yii::getAlias('@root').$img);
        }

        if(is_dir($img) || !file_exists($img)){
            return null;
        }

        if(!self::checkDimensionsLimit($img)) return null;

        // Jpeg quality
        $quality = 80;
        // Method for resizing
        $method = 'resize';

        if(isset($options['method']))
            $method = $options['method'];

        if($options){
            extract($options, EXTR_IF_EXISTS);
        }

        $pathinfo = pathinfo($img);
        $thumb_name = $pathinfo['filename'].'_'.$width.'x'.$height.'.'.$pathinfo['extension'];
        $thumb_path = self::getThumbDir();
        if(!file_exists($thumb_path)){
            mkdir($thumb_path, 0777, true);
        }

        if(!file_exists($thumb_path.$thumb_name) || filemtime($thumb_path.$thumb_name) < filemtime($img))
        {
            $options = ['jpegQuality' => $quality];
            $thumb = PhpThumbFactory::create($img, $options);
            $thumb->{$method}($width, $height);
            $thumb->save($thumb_path.$thumb_name);

            @chmod($thumb_path.$thumb_name, 0664);
        }

        $relative_path = str_replace(Yii::getAlias('@root'), '', $thumb_path.$thumb_name);

        return $relative_path;
    }

    public static function resize($width, $height, $img)
    {
        if(!file_exists($img)){
            $img = str_replace('\\', '/', Yii::getAlias('@root').$img);
        }

        if(is_dir($img) || !file_exists($img)){
            return null;
        }

        if(!self::checkDimensionsLimit($img)) return null;

        // Jpeg quality
        $quality = 80;

        $pathinfo = pathinfo($img);
        $thumb_path = $pathinfo['dirname'].'/';

        $options = ['jpegQuality' => $quality];
        $thumb = PhpThumbFactory::create($img, $options);
        $thumb->resize($width, $height);
        $thumb->save($img);

        @chmod($img, 0664);
    }

    /**
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     * @param string $img
     * @param array $options
     * @return string $path
     */
    public static function crop($x, $y, $width, $height, $img, $options = null)
    {
        $x = (int)$x;
        $y = (int)$y;
        $width = (int)$width;
        $height = (int)$height;

        if(!file_exists($img)){
            $img = str_replace('\\', '/', Yii::getAlias('@root').$img);
        }

        if(is_dir($img) || !file_exists($img)){
            return null;
        }

        if(!self::checkDimensionsLimit($img)) return null;

        // Jpeg quality
        $quality = 80;
        $method = 'crop';

        if($options){
            extract($options, EXTR_IF_EXISTS);
        }

        $pathinfo = pathinfo($img);
        $thumb_name = "c_".$pathinfo['filename'].'_'.$x.'_'.$y.'_'.$width.'_'.$height.'.'.$pathinfo['extension'];
        $thumb_path = self::getThumbDir();

        if(!file_exists($thumb_path)){
            mkdir($thumb_path);
        }

        if(!file_exists($thumb_path.$thumb_name) || filemtime($thumb_path.$thumb_name) < filemtime($img))
        {
            $options = ['jpegQuality' => $quality];
            $thumb = PhpThumbFactory::create($img, $options);
            $thumb->crop($x, $y, $width, $height);
            $thumb->save($thumb_path.$thumb_name);

            @chmod($thumb_path.$thumb_name, 0664);

            self::clearThumbPath();
        }

        $relative_path = str_replace(Yii::getAlias('@root'), '', $thumb_path.$thumb_name);
        return $relative_path;
    }

    public static function getPicture($pic_path, $width=100, $height=100, $noimage_path=false, $options = null)
    {
        $src = '';
        if(file_exists(Yii::getAlias('@root').$pic_path))
        {
            $src = ImageHelper::thumb($width, $height, Yii::getAlias('@root').$pic_path, $options);
        }
        elseif($noimage_path) {

            $src = ImageHelper::thumb($width, $height, Yii::getAlias('@root').$noimage_path, $options);
        }

        return $src;
    }

    public static function downloadImage($url, $upload_type, $filename)
    {
        $uploadSettings = FileUploads::uploadSettings($upload_type);

        $file = explode('.', $filename);
        $file_ext = $file[1];
        $file_name = $file[0];

        $data = FileHelper::getData($url, true);
        if($data)
        {
            $tmp_file = new FileUploads();
            $tmp_file->file_extention = $file_ext;
            $tmp_file->file_realname = $file_name;
            $tmp_file->file_path = $uploadSettings['uploadPath'];
            if($tmp_file->saveTmpFile())
            {
                $file_name = Yii::getAlias('@root').FileUploads::TMP_FILE_PATH.$tmp_file->file_name.'.'.$tmp_file->file_extention;
                if($f = fopen($file_name, 'w'))
                {
                    fwrite($f, $data);
                    fclose($f);

                    if(!FileHelper::is_image(Yii::getAlias('@root').FileUploads::TMP_FILE_PATH.$tmp_file->file_name.'.'.$tmp_file->file_extention))
                    {
                        if(file_exists($file_name) && !is_dir($file_name)) unlink($file_name);
                        $tmp_file->deleteFile();

                    } else return $tmp_file->id;
                }
            }
        }

        return null;
    }

    private static function checkDimensionsLimit($img)
    {
        $image_info = getimagesize($img);

        if(self::ORIGINAL_MAX_WIDTH>0 && $image_info[0]>self::ORIGINAL_MAX_WIDTH) return false;
        if(self::ORIGINAL_MAX_HEIGHT>0 && $image_info[1]>self::ORIGINAL_MAX_HEIGHT) return false;

        return true;
    }

    public static function clearThumbPath()
    {
        $directory = str_replace('\\', '/', self::getThumbDir());
        if(is_dir($directory))
        {
            $dp = opendir($directory);
            while($filename = readdir($dp))
            {
                if(!is_dir($directory.'/'.$filename))
                {
                    if(filemtime($directory.'/'.$filename) < strtotime('- 1 day')) unlink($directory.'/'.$filename);
                }
            }
        }
        $dp = closedir();
    }
}