<?php

namespace App\Enums;

enum UserPreferenceKey: string
{
    case THEME = 'theme';
    case EMAIL_SUBSCRIPTION = 'email_subscription';

    public function validValues(): array
    {
        return match ($this) {
            self::THEME => ['light', 'dark'],
            self::EMAIL_SUBSCRIPTION => ['yes', 'no'],
        };
    }
}
