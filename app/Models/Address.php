<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;


    public function federativeUnit()
    {
        return $this->belongsTo(FederativeUnit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
