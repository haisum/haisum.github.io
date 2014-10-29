<?php
/**
 * CUploadedFile class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CUploadedFile represents the information for an uploaded file.
 *
 * Call {@link get_instance} to retrieve the instance of an uploaded file,
 * and then use {@link save_as} to save it on the server.
 * You may also query other information about the file, including {@link name},
 * {@link temp_name}, {@link type}, {@link size} and {@link error}.
 *
 * @property string $name The original name of the file being uploaded.
 * @property string $tempName The path of the uploaded file on the server.
 * Note, this is a temporary file which will be automatically deleted by PHP
 * after the current request is processed.
 * @property string $type The MIME-type of the uploaded file (such as "image/gif").
 * Since this MIME type is not checked on the server side, do not take this value for granted.
 * Instead, use {@link CFileHelper::getMimeType} to determine the exact MIME type.
 * @property integer $size The actual size of the uploaded file in bytes.
 * @property integer $error The error code.
 * @property boolean $hasError Whether there is an error with the uploaded file.
 * Check {@link error} for detailed error code information.
 * @property string $extensionName The file extension name for {@link name}.
 * The extension name does not include the dot character. An empty string
 * is returned if {@link name} does not have an extension name.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web
 * @since 1.0
 */
class UploadedFile
{

	private $_name;
	private $_tempName;
	private $_type;
	private $_size;
	private $_error;
	private $_validationErrors;

	/**
	 * Returns an instance of the specified uploaded file.
	 * The file should be uploaded using {@link CHtml::activeFileField}.
	 * @param CModel $model the model instance
	 * @param string $attribute the attribute name. For tabular file uploading, this can be in the format of "[$i]attributeName", where $i stands for an integer index.
	 * @return CUploadedFile the instance of the uploaded file.
	 * Null is returned if no file is uploaded for the specified model attribute.
	 * @see getInstanceByName
	 */
	public static function get_instance($attribute)
	{
		if(!isset($_FILES, $_FILES[$attribute]) || !$_FILES[$attribute]['name'])
			return false;
		$info = $_FILES[$attribute];
		return new UploadedFile($info['name'], $info['tmp_name'], $info['type'], $info['size'], $info['error']);
	}

	/**
	 * Constructor.
	 * Use {@link get_instance} to get an instance of an uploaded file.
	 * @param string $name the original name of the file being uploaded
	 * @param string $tempName the path of the uploaded file on the server.
	 * @param string $type the MIME-type of the uploaded file (such as "image/gif").
	 * @param integer $size the actual size of the uploaded file in bytes
	 * @param integer $error the error code
	 */
	protected function __construct($name,$tempName,$type,$size,$error)
	{
		$this->_name=$name;
		$this->_tempName=$tempName;
		$this->_type=$type;
		$this->_size=$size;
		$this->_error=$error;
	}

	/**
	 * String output.
	 * This is PHP magic method that returns string representation of an object.
	 * The implementation here returns the uploaded file's name.
	 * @return string the string representation of the object
	 */
	public function __toString()
	{
		return $this->_name;
	}

	/**
	 * Saves the uploaded file.
	 * Note: this method uses php's move_uploaded_file() method. As such, if the target file ($file) 
	 * already exists it is overwritten.
	 * @param string $file the file path used to save the uploaded file
	 * @param boolean $deleteTempFile whether to delete the temporary file after saving.
	 * If true, you will not be able to save the uploaded file again in the current request.
	 * @return boolean true whether the file is saved successfully
	 */
	public function saveAs($file,$deleteTempFile=true)
	{
		if($this->_error==UPLOAD_ERR_OK)
		{
			if($deleteTempFile)
				return move_uploaded_file($this->_tempName,$file);
			elseif(is_uploaded_file($this->_tempName))
				return copy($this->_tempName, $file);
			else
				return false;
		}
		else
			return false;
	}

	/**
	 * @return string the original name of the file being uploaded
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * @return string the path of the uploaded file on the server.
	 * Note, this is a temporary file which will be automatically deleted by PHP
	 * after the current request is processed.
	 */
	public function getTempName()
	{
		return $this->_tempName;
	}

	/**
	 * @return string the MIME-type of the uploaded file (such as "image/gif").
	 * Since this MIME type is not checked on the server side, do not take this value for granted.
	 * Instead, use {@link CFileHelper::getMimeType} to determine the exact MIME type.
	 */
	public function getType()
	{
		return $this->_type;
	}

	/**
	 * @return integer the actual size of the uploaded file in bytes
	 */
	public function getSize()
	{
		return $this->_size;
	}

	/**
	 * Returns an error code describing the status of this file uploading.
	 * @return integer the error code
	 * @see http://www.php.net/manual/en/features.file-upload.errors.php
	 */
	public function getError()
	{
		return $this->_error;
	}

	/**
	 * Returns errors occured in validation
	 * @return array of errors
	 */
	public function getValidationErrors()
	{
		return $this->_validationErrors;
	}

	/**
	 * @return boolean whether there is an error with the uploaded file.
	 * Check {@link error} for detailed error code information.
	 */
	public function getHasError()
	{
		return $this->_error!=UPLOAD_ERR_OK;
	}

	/**
	 * @return string the file extension name for {@link name}.
	 * The extension name does not include the dot character. An empty string
	 * is returned if {@link name} does not have an extension name.
	 */
	public function getExtensionName()
	{
		if(($pos=strrpos($this->_name,'.'))!==false)
			return (string)substr($this->_name,$pos+1);
		else
			return '';
	}
	/**
	 * validates if file is one of allowedTypes
	 * @param  array $allowedTypes list of allowed extensions
	 * @return boolean true on success false on failure
	 */
	public function validate($types, $maxSize = null, $minSize = null, $mimeTypes = null){
		$this->_validationErrors = [];
		$error = $this->getError();
		$message = "";
		if($error==UPLOAD_ERR_INI_SIZE || $error==UPLOAD_ERR_FORM_SIZE || $maxSize!==null && $this->getSize()>$maxSize)
		{
			$message = 'The file ' . $this->_name . ' is too large.';
		}
		elseif($error==UPLOAD_ERR_PARTIAL)
			$message = 'The file "' . $this->_name . '" was only partially uploaded.';
		elseif($error==UPLOAD_ERR_NO_TMP_DIR)
			$message = 'Missing the temporary folder to store the uploaded file "' . $this->_name . ' "';
		elseif($error==UPLOAD_ERR_CANT_WRITE)
			$message = 'Failed to write the uploaded file "' . $this->_name . '" to disk.';
		elseif(defined('UPLOAD_ERR_EXTENSION') && $error==UPLOAD_ERR_EXTENSION)  // available for PHP 5.2.0 or above
			$message = 'A PHP extension stopped the file upload.';
		
		if($message){
			$this->_validationErrors[] = $message;
		}

		if($minSize!==null && $this->_size<$minSize)
		{
			$message='The file "' . $this->_name . '" is too small. Its size cannot be smaller than ' . $minSize . ' bytes.';
			$this->_validationErrors[] = $message;
		}
		if($types!==null)
		{
			if(is_string($types))
				$types=preg_split('/[\s,]+/',strtolower($types),-1,PREG_SPLIT_NO_EMPTY);
			else
				$types=$types;
			if(!in_array(strtolower($this->getExtensionName()),$types))
			{
				$message= 'The file "' . $this->_name . '" cannot be uploaded. Only files with these extensions are allowed: ' . implode(', ',$types) .  '.';
				$this->_validationErrors[] = $message;
			}
		}
		if($mimeTypes!==null)
		{
			$mimeType = FileHelper::getMimeType($this->getTempName(), null, false);
			if(is_string($mimeTypes))
				$mimeTypes=preg_split('/[\s,]+/',strtolower($mimeTypes),-1,PREG_SPLIT_NO_EMPTY);

			if($mimeType===false || !in_array(strtolower($mimeType),$mimeTypes))
			{
				$message='The file "' . $this->_name . '" cannot be uploaded. Only files of these MIME-types are allowed: ' . implode(",", $mimeTypes) . ". File's mimetype: $mimeType";
				$this->_validationErrors[] = $message;
			}
		}
		if(!$this->_validationErrors){
			return true;
		}
		else{
			return false;
		}
	}
}
