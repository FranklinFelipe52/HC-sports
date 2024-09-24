<?php

namespace App\Console\Commands;

use App\Mail\MeiaConfirmRegistrationMailble;
use App\Mail\RegistrationSuccessMailble;
use App\Models\PrfUser;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email {dia}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   try {$dia = $this->argument('dia');
        $qt_users = 500;
        $skip = $dia*$qt_users;
        $users = PrfUser::skip($skip)->take(500)->get();
        foreach ($users as $user) {
            $registration = $user->registrations[0];
            if($registration->status_regitration_id == 1){
                Mail::to($registration->prf_user->email)->send(new MeiaConfirmRegistrationMailble($registration));
                $this->info('Enviado confirmação de inscrição || ID: '.$registration->id);
                sleep(1);
            } else {
                Mail::to($user->email)->send(new RegistrationSuccessMailble($registration));
                $this->info('Enviado confirmação de cadastro || ID: '.$registration->id);
                sleep(1);
            }
            
        }
       
        return Command::SUCCESS;
    } catch (Exception $e) {
        $this->info($e);
        return Command::FAILURE;
    }
    }
}
