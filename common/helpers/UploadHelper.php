<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 12:48 PM
 */

namespace common\helpers;

use Yii;
use yii\helpers\FileHelper;

class UploadHelper
{

    public static function upload($uploaded_file, $model, $file_attribute, $file_name, $file_dir)
    {
        try {
            $file_path = $file_dir . $file_name;

            FileHelper::createDirectory($file_dir);

            if ($uploaded_file && $model->validate()) {
                if ($uploaded_file->saveAs($file_path)) {
                    $model->$file_attribute = $file_name;
                    return true;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {

        }
    }
}