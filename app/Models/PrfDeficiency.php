<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfDeficiency extends Model
{
    use HasFactory;

    public function prf_users()
    {
        return $this->hasMany(PrfUser::class);
    }
}
