<?php

namespace App\Data;

use App\Services\Enum\StageDeal;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class DealsData extends Data
{
    public function __construct(
        public int $id,
        #[Required, StringType]
        public string $Deal_Name,
        #[Required, StringType, Enum(StageDeal::class)]
        public string $Stage,
    ) {
    }


}
