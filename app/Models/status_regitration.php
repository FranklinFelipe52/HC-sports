<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_regitration extends Model
{
    use HasFactory;

    public function registration(){
        return $this->hasMany(Modalities::class);
    }
}
