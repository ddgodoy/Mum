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
            $thumbName = sprintf('%s.%s', $fileName . '_mini', $mimeType);

            $fileFullPath = sprintf('%s%s', $this->fileBasePath, $fileFullName);
            if (file_put_contents($fileFullPath, base64_decode($fileData))) {
                //$this->fileBasePath "uploads/customer/file/"
                //$this->fileBaseURL "http://192.168.1.129/"
                //$fileFullPath "uploads/customer/file/575b17e4209ac.jpg"
                //$fileFullName "575b17e4209ac.jpg"
                //$thumbName "575b17e4209ac_mini.jpg"
                switch ($mimeType) {
                    case "jpg":
                    case "jpeg":
                        $img = imagecreatefromjpeg($fileFullPath);
                        break;
                    case "png":
                        $img = imagecreatefrompng($fileFullPath);
                        break;
                    case "gif":
                        $img = imagecreatefromgif($fileFullPath);
                        break;
                }

                $file_info = getimagesize($fileFullPath);
                // relación de aspecto
                $ratio = $file_info[0] / $file_info[1];// ancho por alto
                // nuevas dimensiones
                $newwidth = 200; //200 pixeles el ancho predeterminado

                if ($file_info[0] > 200) {
                    $newheight = round($newwidth / $ratio);
                } else {
                    $newwidth = $file_info[0];
                    $newheight = $file_info[1];
                }

                // creo la miniatura
                $thumb = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresized($thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $file_info[0], $file_info[1]);

                //guardo la miniatura
                $thumbFullUrl = sprintf('%s%s', $this->fileBasePath, $thumbName);
                switch ($mimeType) {
                    case "jpg":
                    case "jpeg":
                        imagejpeg($thumb, $thumbFullUrl);
                        break;
                    case "png":
                        imagepng($thumb, $thumbFullUrl);
                        break;
                    case "gif":
                        imagegif($thumb, $thumbFullUrl);
                        break;
                }

                $fileFullURL = sprintf('%s%s', $this->fileBaseURL, $thumbFullUrl);
                return $fileFullURL;
            } else {
                return false;
            }
        }
    }
}

