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
        $value = self::where('key', $key)->value('value');
        if (is_null($value)) {
            return $default;
        }

        // Auto-migrate from storage/ to uploads/ if it exists in storage but not in public
        if (in_array($key, ['site_logo', 'site_favicon', 'about_image']) && str_starts_with($value, 'storage/')) {
            $cleanPath = str_replace('storage/', '', $value); // e.g. 'uploads/logo_xxx.png'
            $oldPath = storage_path('app/public/' . $cleanPath);
            $newPath = public_path($cleanPath);

            if (file_exists($oldPath)) {
                if (!file_exists(dirname($newPath))) {
                    @mkdir(dirname($newPath), 0755, true);
                }
                if (!file_exists($newPath)) {
                    @copy($oldPath, $newPath);
                }
                // Update database so we don't do this check/copy every time
                self::where('key', $key)->update(['value' => $cleanPath]);
                $value = $cleanPath;
            } else {
                // If the file doesn't exist in storage/app/public but does in public/uploads, update the path
                if (file_exists($newPath)) {
                    self::where('key', $key)->update(['value' => $cleanPath]);
                    $value = $cleanPath;
                }
            }
        }

        return $value;
    }
}

