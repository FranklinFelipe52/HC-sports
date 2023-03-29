<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    use HasFactory;

    public function rules(){
        return $this->belongsToMany(Rule::class, 'rules_permissions', 'permissions_id', 'rule_id');
    }
}
