<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use BelongsToCompany;

    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("settings.{$key}." . (auth()->user()->company_id ?? 0), function () use ($key, $default) {
            $setting = self::find($key);
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Get a global platform setting (bypassing tenant isolation).
     */
    public static function getGlobal(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("settings.global.{$key}", function () use ($key, $default) {
            $setting = self::withoutGlobalScopes()->where('key', $key)->whereNull('company_id')->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a global platform setting.
     */
    public static function setGlobal(string $key, ?string $value): void
    {
        self::withoutGlobalScopes()->updateOrCreate(
            ['key' => $key, 'company_id' => null],
            ['value' => $value]
        );

        Cache::forget("settings.global.{$key}");
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param string|null $value
     * @return void
     */
    public static function set(string $key, ?string $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("settings.{$key}");
    }
}
