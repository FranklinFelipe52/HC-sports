<?php

namespace App\Console\Commands;

use App\Helpers\ValorTotal;
use App\Models\PrfRegistration;
use App\Models\PrfUser;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Console\Command;

class VerificarVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:verificar_vouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se um usuário usou um voucher ou cupom de 100% de desconto e confirma sua inscrição';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $registrations = PrfRegistration::get();

            foreach ($registrations as $registration) {
                $voucher_usado = PrfVauchers::find($registration->prf_vauchers_id);

                if ($voucher_usado && $voucher_usado->desconto == 1 && $registration->tshirts > 0) {
                    $registration->status_regitration_id = 1;
                    $registration->save();
                }
            }

            return Command::SUCCESS;

        } catch (Exception $e) {
            return Command::FAILURE;
        }
    }
}
