<?php

namespace Franzip\SerpPageSerializer\Helpers;

/**
 * Namespace useful methods used in tests.
 * @package  SerpPageSerializer
 */
class TestHelper
{
    /**
     * Recursively remove nested dirs and files in $dir by default.
     * @param  string  $dir
     */
    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        self::rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * Clean the filesystem mess created when running tests.
     * Folders to be left untouched are listed in $dontDelete.
     */
    public static function cleanMess()
    {
        $dir = new \DirectoryIterator(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
        echo $dir;
        $dontDelete = array('test', 'src', 'vendor', '.git', 'data');
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()
                && !in_array($fileinfo->getFileName(), $dontDelete)) {
                self::rrmdir($fileinfo->getFilename());
            }
        }
    }

    /**
     * Allow testing private methods.
     * @param  string $name
     * @param  string $className
     * @return callable
     */
    public static function getMethod($name, $className)
    {
        $class = new \ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    private function __constructor() {}
}
