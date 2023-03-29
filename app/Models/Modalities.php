<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalities extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'limit_year_date',
        'mode_modalities_id',
        'modalities_type_id'
    ];

    public function modalities_type(){
        return $this->belongsTo(Modalities_type::class);
    }
    public function mode_modalities(){
        return $this->belongsTo(mode_modalities::class);
    }

    public function modalities_categorys(){
        return $this->hasMany(modalities_category::class);
    }

    public function registrations(){
        return $this->hasMany(registration::class);
    }
}
