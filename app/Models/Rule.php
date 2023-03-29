<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    public function admins(){
        return $this->hasMany(Admin::class);
    }

    public function permissions(){
        return $this->belongsToMany(permissions::class, 'rules_permissions', 'rule_id', 'permissions_id');
    }
}
