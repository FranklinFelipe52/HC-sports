<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfTshirt extends Model
{
    use HasFactory;

    public function registrations(){
        return $this->belongsToMany(PrfRegistration::class, 'prf_tshirt_and_prf_registrations', 'prf_tshirt_id', 'prf_registration_id');
    }
}
