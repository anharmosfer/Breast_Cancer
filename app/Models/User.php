<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'birthdate',
        'gender',
        'age',
        'marital_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const USER_TOKEN = 'userToken';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //=======================  sendPasswordResetNotification  =================

    public function sendPasswordResetNotification($token)
    {

        $url = 'https://spa.test/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

    // Function to calculate age and assign age range
    public function calculateAge()
    {
        // Calculate age from birthdate
        $birthdate = Carbon::parse($this->birthdate);
        $now = Carbon::now();
        $age = $birthdate->diffInYears($now);

        // Assign age to the user
        $this->age = $age;

        // Assign age range based on age
        if ($age >= 20 && $age <= 29) {
            $this->age_range = \App\Enums\AgeRangeEnum::Range_20_to_29;
        } elseif ($age >= 30 && $age <= 39) {
            $this->age_range = \App\Enums\AgeRangeEnum::Range_30_to_39;
        } elseif ($age >= 40 && $age <= 49) {
            $this->age_range = \App\Enums\AgeRangeEnum::Range_40_to_49;
        } elseif ($age >= 50) {
            $this->age_range = \App\Enums\AgeRangeEnum::Range_50_and_above;
        }
    }
}
