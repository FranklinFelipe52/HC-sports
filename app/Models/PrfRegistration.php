<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrfRegistration extends Model
{
    use HasFactory;

    const STATUS_CONFIRMADO = 1;
    const STATUS_AGUARDANDO_ACEITE = 2;
    const STATUS_AGUARDANDO_PAGAMENTO = 3;
    const STATUS_ESTORNADA = 4;
    const STATUS_CANCELADA = 5;

    public function prf_user()
    {
        return $this->belongsTo(PrfUser::class);
    }

    public function prf_categorys()
    {
        return $this->belongsTo(PrfCategorys::class);
    }

    public function prf_package()
    {
        return $this->belongsTo(PrfPackage::class);
    }

    public function prf_payments()
    {
        return $this->hasOne(PrfPayments::class);
    }

    public function prf_pace()
    {
        return $this->belongsTo(PrfPace::class);
    }

    public function status_regitration()
    {
        return $this->belongsTo(status_regitration::class);
    }
    public function prf_size_tshirts()
    {
        return $this->belongsTo(PrfSizeTshirts::class);
    }
    public function prf_vauchers()
    {
        return $this->belongsTo(PrfVauchers::class);
    }
    public function tshirts()
    {
        return $this->belongsToMany(PrfTshirt::class, 'prf_tshirt_and_prf_registrations', 'prf_registration_id', 'prf_tshirt_id');
    }
}