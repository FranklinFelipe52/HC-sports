<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionsAdmin extends Model
{
    use HasFactory;

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function type_actions_admin(){
        return $this->belongsTo(TypeActionsAdmin::class);
    }
}
