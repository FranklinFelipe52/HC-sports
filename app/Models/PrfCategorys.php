<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfCategorys extends Model
{
    use HasFactory;

   

    public function registrations()
    {
        return $this->hasMany(PrfRegistration::class);
    }

    public function prf_size_tshirts(){
        return $this->belongsToMany(PrfSizeTshirts::class, 'prf_size_tshirts_category', 'prf_categorys_id', 'prf_size_tshirts_id');
    }
    public function prf_package()
    {
        return $this->belongsTo(PrfPackage::class);
    }
}
