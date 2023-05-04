<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    use HasFactory;

    public function modalities_modalities(){
        return $this->belongsToMany(Modalities::class, 'range_modalities', 'range_id', 'modalities_id');
    }

    public function registrations(){
        return $this->hasMany(registration::class);
    }
}
