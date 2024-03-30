<?php



namespace App\Enums;

enum GenderEnum: string
{
    const Male = 0;
    const Female = 1;

    public static function toArray(): array
    {
        return [
            self::Male => 'Male',
            self::Female => 'Female',
        ];
    }
}
