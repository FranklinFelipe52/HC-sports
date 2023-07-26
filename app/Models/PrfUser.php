<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfUser extends Model
{
    use HasFactory;

    public function registrations()
    {
        return $this->hasMany(PrfRegistration::class);
    }

    public function actions_notifications(){
        return $this->hasMany(PrfActionsNotification::class);
    }

    public function prf_deficiency(){
        return $this->belongsTo(PrfDeficiency::class);
    }
}
