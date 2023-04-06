<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_payment extends Model
{
    use HasFactory;

    public function registrations(){
        return $this->hasMany(registration::class);
    }
}
