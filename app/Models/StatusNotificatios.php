<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusNotificatios extends Model
{
    use HasFactory;

    public function actions_notifications(){
        return $this->hasMany(ActionsNotificatios::class);
    }
}
