<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfVauchers extends Model
{
    use HasFactory;

    public function prf_registrations()
    {
        return $this->hasMany(PrfRegistration::class);
    }
}
