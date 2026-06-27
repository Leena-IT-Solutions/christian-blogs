<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get setting value by key with optional default.
     */
    public static function getVal(string $key, string $default = ''): string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }
}

