<?php
namespace app\components;
use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class Upload extends Component {

    public $upload_folder = 'uploads';

    public $image_type = ['png','jpg','jpeg'];

    public function uploadMultiple($model,$attribute)
    {
      $files  = UploadedFile::getInstances($model, $attribute);
      $path = $this->getUploadPath();

      if ($model->validate() && $files !== null) {
          $filenames = [];
          foreach ($files as $file) {

                $filename = date("Ymd").rand(0,99).'.'. $file->extension;

	                  if($file->saveAs($path . $filename)){
	                    $filenames[] = $filename;
	                  }
          }

          if($model->isNewRecord){
            return implode(',', $filenames);
          }else{
            return implode(',',(ArrayHelper::merge($filenames,$this->getOwnPhotosToArray($model,$attribute))));
          }
      }

      return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function getOwnPhotosToArray($model,$attribute)
    {
      return $model->getOldAttribute($attribute) ? @explode(',',$model->getOldAttribute($attribute)) : [];
    }

    public function getMultipleViewer($data = null){
        return !empty($data) ? @explode(',',$data) : [];
    }

    public function uploadFile($model, $attribute) {

        $image = UploadedFile::getInstance($model, $attribute);

        $path = $this->getUploadPath();

        if ($model->validate() && $image !== null) {

            $fileName = date("YmdHis"). '.' . $image->extension;

            if ($image->saveAs($path . $fileName)) {
                return $fileName;
            }
        }

        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.$this->upload_folder.'/';
    }

    public function getUploadUrl(){
        return Yii::getAlias('@web').'/'.$this->upload_folder.'/';
    }

    public function getFileViewer($file = null) {

        if (!empty($file)) {

            $filename = $this->getUploadPath() . $file;

            if (file_exists($filename)) {
                return $this->getUploadUrl() . $file;
            }
        }

        return $this->noImage();

    }

    public function noImage(){
        return $this->getUploadUrl(). 'no_image.png';
    }


    public function getPhotosViewer($image = null){
        $photos = !empty($image) ? @explode(',',$image) : [];
        return $photos;
    }


    public function deleteFile($file = null) {

      if (!empty($file)) {

          $filename = $this->getUploadPath() . $file;

          if (file_exists($filename)) {

            if (!@unlink($filename)) {
                echo ("Error deleting $path");
            }
          }
      }

    }


}
