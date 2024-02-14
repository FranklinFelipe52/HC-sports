<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caern_adresses extends Model
{
    use HasFactory;

    public function federativeUnit()
    {
        return $this->belongsTo(FederativeUnit::class);
    }
}
