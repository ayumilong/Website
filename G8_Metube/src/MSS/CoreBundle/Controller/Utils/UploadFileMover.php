<?php

namespace MSS\CoreBundle\Controller\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of UploadFileMover
 *
 * @author yanbai
 */
class UploadFileMover {

    public function moveUploadedFile(UploadedFile $file, $uploadBasePath, $relativePath) {

        $originalName = $file->getClientOriginalName();
        $originalName = str_replace(" ", "", $originalName);

        $name_array = explode('.', $originalName);
        $ext = $name_array[sizeof($name_array) - 1];

        $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
        $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
        //$ext = $file->getExtension();
        $i = 1;
        $tmp = "";

        while (file_exists($targetFilePath) && md5_file($file->getPath()) != md5_file($targetFilePath)) {
            $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath . DIRECTORY_SEPARATOR . $name_array[0] . $i++ . '.' . $ext;
        }

        $targetDir = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath;

        if (!is_dir($targetDir)) {
            if (false === @mkdir($targetDir, 0777, true)) {
                throw new \RuntimeException(sprintf("Unable to create the directory (%s)\n", $targetDir));
            }
        } elseif (!is_writable($targetDir)) {
            throw new \RuntimeException(sprintf("Unable to write in the directory (%s)\n", $targetDir));
        }

        $file->move($targetDir, basename($targetFilePath));

        return str_replace($uploadBasePath . DIRECTORY_SEPARATOR, "", $targetFilePath);
    }

}
