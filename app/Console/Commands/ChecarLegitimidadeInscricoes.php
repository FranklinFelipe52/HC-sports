<?php

namespace App\Console\Commands;

use App\Models\PrfLogPayments;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Console\Command;

class ChecarLegitimidadeInscricoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checar_legitimidade_inscricoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cruza os dados das tabelas de inscrições, pagamentos e log_payments. Verifica se há inscrições dadas como "pagas" sem pagamento confirmado correspondente.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $registrations = PrfRegistration::where('status_regitration_id', 1)->where('validated_by_admin', 0)->get();
            $unusual_registrations_array = [];

            foreach ($registrations as $registration) {

                $voucher = PrfVauchers::find($registration->prf_vauchers_id);

                // elimina inscrições que usaram código de desconto de 100%
                if (!$voucher || $voucher->desconto < 1) {

                    $payment = PrfPayments::find($registration->id);
                    $log_payment = PrfLogPayments::where('prf_registration_id', $registration->id)->first();

                    if ($payment->status_payment_id != 1 || !$log_payment) {
                        array_push($unusual_registrations_array, $registration);
                        $registration->status_regitration_id = 3;
                        $registration->save();
                    }
                }

            }

            $unusual_registrations_ids_array = [];

            if (count($unusual_registrations_array) > 0) {
                foreach ($unusual_registrations_array as $unusual_registration) {
                    array_push($unusual_registrations_ids_array, [
                        'registration_id' => $unusual_registration->id,
                        'user_id' => $unusual_registration->prf_user->id,
                    ]);
                }
            }

            return Command::SUCCESS;

        } catch (Exception $e) {
            return Command::FAILURE;
        }
    }
}
