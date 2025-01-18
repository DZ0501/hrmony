<?php

use App\Enums\SettingKey;
use App\Services\SettingService;

function setting(SettingKey $key)
{
    return app(SettingService::class)->get($key);
}
