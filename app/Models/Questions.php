<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    

    public function criterias()
{
    return $this->belongsToMany(related: Criteria::class, table: 'questions__c_s');

}
}
