<?php

namespace App\Classes;

use App\Models\log_payment;
use App\Models\registration;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Checkout
{

    public Request $request;
    public $token;
    public registration $registration;
    public $url;
    public $mount;
    public  $method;
    

    function __construct( Request $request, int $mount, registration $registration, string $url, int $method)
    {
            $this->request = $request;
            $this->registration = $registration;
            $this->url = $url;
            $this->mount = $mount;
            $this->method =  $method;
        
    }

    public function pay(){
        try{
            $user = $this->request->session()->get('user');
            $log = new log_payment;
            $log->registration_id = $this->registration->id;
            switch ($this->method) {
                case 1:
                    $log->method = "CREDIT_CARD";
                    $data = [
                        "reference_id" => $this->registration->id,
                        "customer" => [
                            "name" => $user->nome_completo,
                            "email" => $user->email,
                            "tax_id" => $user->cpf,
                            ],
                        "items" => [
                            [
                                "reference_id" => $this->registration->id,
                                "name" => $this->registration->modalities->nome,
                                "quantity"=> 1,
                                "unit_amount"=> $this->mount
                            ]
                        ],
                        "charges" => [
                            [
                                "reference_id" => $log->id,
                                "description" => "Pagamento de inscrição",
                                "amount" => [
                                    "value" => $this->mount,
                                    "currency" => "BRL"
                                ],
                                "payment_method" => [
                                    "type" => "CREDIT_CARD",
                                    "installments" => 1,
                                    "capture" => true,
                                    "card" => [
                                        "encrypted" => $this->request->token_card,
                                        "security_code" => $this->request->cvv,
                                        "holder" => [
                                            "name" => $this->request->nome
                                        ],
                                        "store" => false
                                    ]
                                ]
                            ]
                        ]
                        ];
                    break;
                case 2:
                    $time = strtotime(date("Y-m-d H:i:s")) + 24*3600; // Add 1 day
                    $time = date("Y-m-d\TH:i:s-03:00", $time); // Back to string
                    
                    $log->method = "PIX";
                    $data = [
                        "reference_id" =>  $this->registration->id,
                        "customer" => [
                            "name" => $user->nome_completo,
                            "email" => $user->email,
                            "tax_id" => "71210951495",
                            ],
                        "items" => [
                            [
                                "reference_id" => $this->registration->id,
                                "name" => $this->registration->modalities->nome,
                                "quantity"=> 1,
                                "unit_amount"=> $this->mount
                            ]
                        ],
                        "qr_codes" => [
                            [
                                "amount" => [
                                    "value" => $this->mount
                                ],
                                "expiration_date" => $time,
                            ]
                        ]
                        ];
                    break;
                case 3:
                    $log->method = "BOLETO";
                    break;
                default:
                    break;
            }
            $log->save();
            

            $response = Http::withHeaders([
                'Authorization' => "Bearer ".env('PAGSEGURO_SANDBOX_TOKEN')
            ])->post($this->url, $data);
            error_log($response);
            return $response;

        }catch (Exception $e){
            return false;
        }
        
    }
}
