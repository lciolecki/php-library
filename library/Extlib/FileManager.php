<?php

namespace Extlib;

/**
 * FileManager class contains usefull methods for operation on directory and files
 * 
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
final class FileManager
{

    /**
     * Method create directory if not exist
     * 
     * @param string $directory
     * @param boolean $date
     * @return string
     * @throws \Extlib\Exception
     */
    static public function dir($directory, $date = false)
    {
        if ($date) {
            $directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::getDateDirectory();
        }

        if (!is_dir($directory)) {
            umask(0000);

            if (@mkdir($directory, 0777, true) === false) {
                throw new Exception(sprintf('Directory "%s" cannot be created.', $directory));
            }
        }

        return $directory;
    }

    /**
     * Get date as directory - 2013-06-10 to 2013/06/10
     * 
     * @return string
     */
    static public function getDateDirectory()
    {
        return str_replace('-', DIRECTORY_SEPARATOR, \Extlib\System::getInstance()->getDate()->format('Y-m-d'));
    }

    /**
     * Return unique filename for directory
     * 
     * @param string $directory
     * @param string $extension
     * @param  $length
     * @return string
     */
    static public function generateFilename($directory, $extension, $length = 16)
    {
        do {
            $name = \Extlib\Generator::generate($length);
            $filepath = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . sprintf('%s.%s', $name, $extension);
        } while (file_exists($filepath));

        return sprintf('%s.%s', $name, $extension);
    }

    /**
     * Return unique dirname
     *
     * @param string $directory
     * @param int $length
     * @return string
     */
    static public function generateDir($directory, $length = 16)
    {
        do {
            $name = \Extlib\Generator::generate($length);
            $dir = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name ;
        } while (is_dir($filepath));

        return $dir;
    }

    /**
     * Remove file by path
     * 
     * @param string $filename
     * @return boolean
     */
    static public function removeFile($filename)
    {
        if (file_exists($filename)) {
            return unlink($filename);
        }

        return true;
    }

    /**
     * Return mimetype for file
     * 
     * @param string $filePath
     * @param string $default
     * @return string
     */
    static public function getMimeType($filePath, $default = 'application/octet-stream')
    {
        $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath);
        if ($mimeType === false) {
            $mimeType = $default;
        }
        
        return $mimeType;
    }

    /**
     * Correct filepath
     * 
     * @param string $filePath
     * @return string
     */
    static public function correctFilePath($filePath)
    {
        return trim(preg_replace("/\/+/i", DS, preg_replace("/\\\+/i", DIRECTORY_SEPARATOR, $filePath)));
    }

    /**
     * Recursive delete direcotry
     *
     * @param string $path
     * @return boolean 
     */
    static public function recursiveDelete($path)
    {
        if (is_file($path)) {
            return unlink($path);
        }

        $scan = glob(rtrim($path, '/') . '/*');
        foreach ($scan as $path) {
            self::recursiveDelete($path);
        }

        return rmdir($path);
    }

    /**
     * Remove all files from directory
     * 
     * @param string $directory
     * @return boolean
     */
    static public function removeFiles($directory)
    {
        $scan = glob(rtrim($directory, '/') . '/*');
        foreach ($scan as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return true;
    }
}
