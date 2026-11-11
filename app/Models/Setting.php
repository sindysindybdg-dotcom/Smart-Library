<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'group',
    ];

    // Helper: Ambil semua settings sebagai array key => value
    public static function getAllAsArray()
    {
        return self::pluck('setting_value', 'setting_key')->toArray();
    }

    // Helper: Ambil satu value by key
    public static function get($key, $default = null)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    // Helper: Update/create by key
    public static function set($key, $value, $type = 'string')
    {
        return self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value, 'setting_type' => $type, 'updated_at' => now()]
        );
    }
}