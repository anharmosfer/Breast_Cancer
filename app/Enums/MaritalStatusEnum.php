<?php

namespace App\Enums;

enum MaritalStatusEnum: string
{
    case Single = 'single';
    case Married = 'married';
    case Separated = 'separated';
    case Divorced = 'divorced';
    case Widowed = 'widowed';
}
