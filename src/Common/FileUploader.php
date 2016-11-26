<?php

namespace Neitui\Common;

use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    public static function uploadFile($group, File $file)
    {
        $errors = FileToolkit::validateFileExtension($file);
        if ($errors) {
            @unlink($file->getRealPath());
            throw new \Exception("该文件格式，不允许上传。");
        }
        return static::saveFile($file, $group);
    }

    public static function deleteFile($uri, $dir)
    {
        $parsed = static::parseFileUri($uri, $dir);
        if (file_exists($parsed['fullpath'])) {
            @unlink($parsed['fullpath']);
        }
    }

    private static function saveFile($file, $group)
    {
        $uri    = static::generateUri($group, FileToolkit::getFileExtension($file));
        $dir    = static::getBaseDir($group);
        $parsed = static::parseFileUri($uri, $dir);

        if (!is_writable($dir)) {
            throw new \Exception("文件上传路径{$dir}不可写，文件上传失败。");
        }
        $dir .= $parsed['directory'];

        $file->move($dir, $parsed['name']);
        //like : public://avatar/2016/07-11/195733d0389d626384.jpeg
        return $uri;
    }

    private static function parseFileUri($uri, $dir)
    {
        $parsed = array();
        $parts  = explode('://', $uri);
        if (empty($parts) || count($parts) != 2) {
            throw new \Exception("解析文件URI({$uri})失败！");
        }
        $parsed['access']    = $parts[0];
        $parsed['path']      = $parts[1];
        $parsed['directory'] = dirname($parsed['path']);
        $parsed['name']      = basename($parsed['path']);

        //XXX 暂时忽略对私有和公开文件的支持，全部作为公开文件 malianbo@howzhi.com
        $parsed['fullpath'] = $dir.$parsed['path'];

        return $parsed;
    }

    public static function generateUri($group, $ext)
    {
        $uri = self::getGroupPrefix($group).$group['code'].'/';
        $uri .= date('Y').'/'.date('m-d').'/'.date('His');
        $uri .= substr(uniqid(), -6).substr(uniqid('', true), -6);
        $uri .= '.'.$ext;

        return $uri;
    }

    public static function getGroupPrefix($group)
    {
        return $group['public'] ? 'public://' : 'private://';
    }

    public static function getBaseDir($group)
    {
        return ROOT_DIR.($group['public'] ? '/web/files/' : '/var/files/');
    }
}
