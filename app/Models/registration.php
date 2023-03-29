<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'modalities_id',
        'payment_id'
    ];

    public function modalities_categorys(){
        return $this->belongsToMany(modalities_category::class, 'registration_categories', 'registration_id', 'modalities_category_id');
    }

    public function status_regitration(){
        return $this->belongsTo(status_regitration::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payment(){
        return $this->belongsTo(payment::class);
    }

    public function modalities(){
        return $this->belongsTo(Modalities::class);
    }

    public function log_payments(){
        return $this->hasMany(log_payment::class);
    }
}
