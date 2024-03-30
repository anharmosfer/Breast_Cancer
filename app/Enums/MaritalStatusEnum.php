<?php

namespace App\Enums;

enum MaritalStatusEnum: string
{
    const Single = 0;
    const Married = 1;
    const Separated = 2;
    const Divorced = 3;
    const Widowed = 4;

    public static function toArray(): array
    {
        return [
            self::Single => 'Single',
            self::Married => 'Married',
            self::Separated => 'Separated',
            self::Divorced => 'Divorced',
            self::Widowed => 'Widowed',
        ];
    }
}
