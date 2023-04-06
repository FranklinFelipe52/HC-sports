<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalities_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'max_total',
        'max_f' ,
        'max_m',
        'min_year',
        'modalities_id',
    ];

   

    public function modalities(){
        return $this->belongsTo(Modalities::class);
    }

    public function registrations(){
        return $this->hasMany(registration::class);
    }
}
