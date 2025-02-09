<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public int|null $id,
        public string $firstName,
        public string $lastName,
        #[MapInputName('id')]
        public int $zohoId,
        public string $country,
        public string $state,
        public string $accessToken,
        public string $refreshToken,
        public int $expiresIin,
    ) {
    }
}
