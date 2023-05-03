<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActionsAdmin extends Model
{
    use HasFactory;

    public function actions_admin(){
        return $this->hasMany(ActionsAdmin::class);
    }
}
