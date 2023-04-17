<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'data_nasc',
        'cpf',
        'is_pcd',
        'n_oab',
        'sexo',
        'email',
        'password',
    ];


    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function registrations()
    {
        return $this->hasMany(registration::class);
    }

    public function actions_notifications(){
        return $this->hasMany(ActionsNotificatios::class);
    }
}
