<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AthleteWhitelist extends Model
{
    protected $table = 'athlete_whitelist';

    protected $fillable = ['document', 'type', 'max_registrations'];

    public static function findDocument(string $document): ?self
    {
        $clean = preg_replace('/[^0-9]/', '', $document);
        return self::where('document', $clean)->first();
    }

    public function registrationCount(): int
    {
        return PrfRegistration::where('whitelist_document', $this->document)->count();
    }

    public function hasSlotAvailable(): bool
    {
        if (is_null($this->max_registrations)) {
            return true;
        }
        return $this->registrationCount() < $this->max_registrations;
    }
}
