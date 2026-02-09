<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null): ?string
    {
        return Cache::remember("system_setting.{$key}", 60, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("system_setting.{$key}");
    }

    /**
     * Check if peer evaluation is enabled.
     */
    public static function isPeerEvaluationEnabled(): bool
    {
        return static::get('peer_evaluation_enabled', '0') === '1';
    }
}
