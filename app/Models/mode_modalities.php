<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mode_modalities extends Model
{
    use HasFactory;

    public function modalities(){
        return $this->hasMany(Modalities::class);
    }
}
