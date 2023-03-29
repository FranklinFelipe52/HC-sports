<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo' ,
        'cpf' ,
        'email',
        'password',
        'federative_unit_id',
        'rule_id'
    ];

    public function rule(){
        return $this->belongsTo(Rule::class);
    }
    public function federativeUnit(){
        return $this->belongsTo(FederativeUnit::class);
    }
}
