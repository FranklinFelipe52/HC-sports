<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfActionsNotification extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(PrfUser::class);
    }

    public function status_notification(){
        return $this->belongsTo(StatusNotificatios::class);
    }
}
