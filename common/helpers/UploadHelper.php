<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 12:48 PM
 */

namespace common\helpers;

use Imagine\Gd\Imagine;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Yii;
use yii\helpers\FileHelper;

class UploadHelper
{

    public static function upload($uploaded_file, $model, $file_attribute, $file_name, $file_dir)
    {
        try {
            $file_path = $file_dir . $file_name;

            FileHelper::createDirectory($file_dir);

            if ($uploaded_file) { //&& $model->validate()
                if ($uploaded_file->saveAs($file_path)) {
                    $model->$file_attribute = $file_name;
                    $model->save();
                    return true;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {

        }
    }

    public static function getImageInfo($image_path)
    {
        $imagine = new Imagine();
        $image = $imagine->open($image_path);
        $metadata = $image->metadata();
        Yii::warning('metadata: ' . print_r($metadata, true));

    }


    public static function getReadImage($image_path)
    {
//        $path = getenv('PATH');
//        putenv("PATH=$path:C:\Program Files (x86)\Tesseract-OCR");

        $ocr = new TesseractOCR();
        $ocr->image($image_path);
        $ocr->executable("/usr/local/bin/tesseract");
        $text = $ocr->run();
//        $text = getenv('PATH');;

        Yii::warning('ocr text: ' . $text);
    }
}