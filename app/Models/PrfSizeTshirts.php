<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfSizeTshirts extends Model
{
    use HasFactory;

    public function prf_registrations()
    {
        return $this->hasMany(PrfRegistration::class);
    }

    public function prf_categorys(){
        return $this->belongsToMany(PrfCategorys::class, 'prf_size_tshirts_category', 'prf_size_tshirts_id', 'prf_categorys_id');
    }
}
