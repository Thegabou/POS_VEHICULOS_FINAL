<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class GlobalVariable
{
    protected static $filePath;

    public static function init()
    {
        self::$filePath = storage_path('app/global_variables.json');
    }

    public static function all()
    {
        self::init();
        if (!File::exists(self::$filePath)) {
            return [];
        }
        return json_decode(File::get(self::$filePath), true);
    }

    public static function get($key, $default = null)
    {
        self::init();
        $variables = self::all();
        return $variables[$key] ?? $default;

        
    }

    public static function set($key, $value)
    {
        self::init();
        $variables = self::all();
        $variables[$key] = $value;
        File::put(self::$filePath, json_encode($variables));
    }

    public static function delete($key)
    {
        self::init();
        $variables = self::all();
        if (isset($variables[$key])) {
            unset($variables[$key]);
            File::put(self::$filePath, json_encode($variables));
        }
    }
}
