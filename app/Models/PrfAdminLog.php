<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfAdminLog extends Model
{
    use HasFactory;

    public function prf_admin(){
        return $this->belongsTo(PrfAdmin::class);
    }

    public function type_actions_admin(){
        return $this->belongsTo(TypeActionsAdmin::class);
    }
}
