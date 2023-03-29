<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_category extends Model
{
    use HasFactory;

    public function modalities_category(){
        return $this->hasMany(modalities_category::class);
    }
}
