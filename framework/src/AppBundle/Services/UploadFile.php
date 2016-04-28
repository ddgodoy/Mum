<?php

namespace AppBundle\Services;

/**
 * Class UploadFile
 *
 * @package AppBundle\Services
 */
class UploadFile
{
    /**
     * @var string
     */
    private $fileBasePath;

    /**
     * @var string
     */
    private $fileBaseURL;    

    /**
     * UploadFile constructor.
     *
     * @param string $fileBasePath
     * @param string $fileBaseURL
     */
    public function __construct($fileBasePath, $fileBaseURL)
    {
        $this->fileBasePath = $fileBasePath;
        $this->fileBaseURL = $fileBaseURL;        
    }

    /**
     * 
     * Upload file: jpg, jpeg, doc, excel y pdf
     * 
     * @param string $fileData
     * @param string $mimeType
     * @return string
     */
    public function upload($fileData = null, $mimeType = null)
    {
        if ($fileData) {
            $fileName = uniqid();
            $fileFullName = sprintf('%s.%s', $fileName, $mimeType);
            
            $fileFullPath = sprintf('%s%s', $this->fileBasePath, $fileFullName);
            if (!file_put_contents($fileFullPath, base64_decode($fileData))) {
                return false;
            }

            $fileFullURL = sprintf('%s%s', $this->fileBaseURL, $fileFullPath);            
            return $fileFullURL;
        }
    }
}

