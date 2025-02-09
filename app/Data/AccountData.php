<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;

class AccountData extends Data
{

    public function __construct(
        public int $id,
        #[Required, StringType, Max(120)]
        public string $Phone,
        #[Required, Url, Max(191)]
        public string $Website,
        #[Required, StringType, Max(120)]
        public string $Account_Name,
    ) {
    }
}
