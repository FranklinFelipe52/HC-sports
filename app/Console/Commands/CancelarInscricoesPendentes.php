<?php

namespace App\Console\Commands;

use App\Models\PrfRegistration;
use Illuminate\Console\Command;

class CancelarInscricoesPendentes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cancelar-inscricoes-pendentes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muda o status de todas inscrições pendentes para Cancelado';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            PrfRegistration::where('status_regitration_id', PrfRegistration::STATUS_AGUARDANDO_PAGAMENTO)->update(['status_regitration_id' => PrfRegistration::STATUS_CANCELADA]);

            return Command::SUCCESS;
        } catch (\Throwable $th) {
            info('erro', ['th' => $th]);
            return Command::FAILURE;
        }

    }
}
