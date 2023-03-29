<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalities_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo' ,
        'min_f' ,
        'min_m',
        'min_year',
        'modalities_id',
        'group_category_id'
    ];

    public function registrations(){
        return $this->belongsToMany(registration::class, 'registration_categories', 'modalities_category_id', 'registration_id');
    }

    public function modalities(){
        return $this->belongsTo(Modalities::class);
    }

    public function group_category(){
        return $this->belongsTo(group_category::class);
    }
}
