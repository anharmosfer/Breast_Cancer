<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    // public function questions() {
    //     return $this->belongsToMany(Questions::class);
    // }

    public function Users()
    {
        return $this->belongsToMany(related: User::class , table: 'user__c_s');

    }
    public function Questions()
    {
        return $this->belongsToMany(related: Questions::class , table: 'uestions__c_s');

    }
}
