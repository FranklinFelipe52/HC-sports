<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'registration_id'
    ];

    public function registration(){
        return $this->belongsTo(registration::class);
    }
}
