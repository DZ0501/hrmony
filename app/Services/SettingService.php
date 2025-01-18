<?php

namespace App\Services;

use App\Enums\SettingKey;
use App\Models\Setting;
use Illuminate\Support\Collection;

/**
 * Class SettingService.
 */
class SettingService
{
    public function get(SettingKey $key): ?string
    {
        return Setting::where('key', $key->value)->value('value');
    }
    public function getAllSettings(): Collection
    {
        return Setting::all();
    }
    public function updateSetting(SettingKey $key, ?string $value): void
    {
        Setting::where('key', $key->value)->update(['value' => $value]);
    }
}
