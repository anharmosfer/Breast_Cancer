<?php

namespace App\Enums;

enum AgeRangeEnum: int
{
    const Range_20_to_29 = 0;
    const Range_30_to_39 = 1;
    const Range_40_to_49 = 2;
    const Range_50_and_above = 3;

    public static function toArray(): array
    {
        return [
            self::Range_20_to_29 => '20-29',
            self::Range_30_to_39 => '30-39',
            self::Range_40_to_49 => '40-49',
            self::Range_50_and_above => '50 and above',
        ];
    }
}
