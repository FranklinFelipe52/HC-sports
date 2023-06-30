<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfPayments extends Model
{
    use HasFactory;

    public function registration(){
        return $this->belongsTo(PrfRegistration::class);
    }
    public function status_payment(){
        return $this->belongsTo(status_payment::class);
    }
}
