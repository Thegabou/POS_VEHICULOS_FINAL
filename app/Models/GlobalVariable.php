<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class GlobalVariable
{
    protected static $filePath;

    public function __construct()
    {
        self::$filePath = storage_path('app/global_variables.json');
    }

    public static function all()
    {
        if (!File::exists(self::$filePath)) {
            return [];
        }
        return json_decode(File::get(self::$filePath), true);
    }

    public static function get($key)
    {
        $variables = self::all();
        return $variables[$key] ?? null;
    }

    public static function set($key, $value)
    {
        $variables = self::all();
        $variables[$key] = $value;
        File::put(self::$filePath, json_encode($variables));
    }

    public static function delete($key)
    {
        $variables = self::all();
        if (isset($variables[$key])) {
            unset($variables[$key]);
            File::put(self::$filePath, json_encode($variables));
        }
    }
}
