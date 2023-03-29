<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederativeUnit extends Model
{
    use HasFactory;


    public function addres()
    {
        return $this->hasMany(Address::class);
    }

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }
}
