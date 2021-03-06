<?php

namespace app\modules\api1\models;

use app\components\traits\ModelHelperTrait;
use app\enums\FileExtension;
use yii\base\Model;
use yii\validators\FileValidator;

/**
 * Class Uploader
 *
 * @property string $filePath
 *
 * @package app\modules\api1\models
 */
class Uploader extends Model
{
    const FILE_EXTENSIONS = FileExtension::FLV;

    use ModelHelperTrait;

    private $_validator;

    public function init()
    {
        $this->_validator = new FileValidator( [ 'skipOnEmpty' => false, 'extensions' => self::FILE_EXTENSIONS ] );
    }

    /**
     * Validate uploaded file and save it.
     * @param \yii\web\UploadedFile $file
     * @param string $saveFilePath
     * @return bool
     */
    public function save( $file, $saveFilePath )
    {
        $error = null;
        if ( !$this->_validator->validate( $file, $error ) )
        {
            $this->addError( 'file', $error );
            return false;
        }
        if ( !$file->saveAs( $saveFilePath ) )
        {
            $this->addError( 'file', 'File could not be saved' );
            return false;
        }
        return true;
    }
}