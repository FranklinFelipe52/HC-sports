<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfPayments extends Model
{
    use HasFactory;

    const STATUS_APROVADO = 1;
    const STATUS_REJEITADO = 2;
    const STATUS_PENDENTE = 3;

    public function registration(){
        return $this->belongsTo(PrfRegistration::class);
    }
    public function status_payment(){
        return $this->belongsTo(status_payment::class);
    }
}
