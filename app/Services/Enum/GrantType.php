<?php

namespace App\Services\Enum;

enum GrantType: string
{
    case REFRESH_TOKEN = 'refresh_token';
    case AUTHORIZATION_CODE = 'authorization_code';
}
