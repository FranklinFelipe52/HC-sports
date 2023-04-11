<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'method'
    ];
    public function registration(){
        return $this->belongsTo(registration::class);
    }
    public function status_payment(){
        return $this->belongsTo(status_payment::class);
    }
}
