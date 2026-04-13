<?php

namespace App\Console\Commands;

use App\Models\AthleteWhitelist;
use Illuminate\Console\Command;

class ImportWhitelist extends Command
{
    protected $signature = 'whitelist:import {file : Caminho do arquivo CSV/TXT} {--max= : Limite de inscrições por CNPJ (padrão: sem limite)} {--force : Substituir registros existentes}';

    protected $description = 'Importa CPFs e CNPJs para a whitelist de atletas autorizados.
        Formato do arquivo: uma linha por documento (só dígitos ou formatado).
        Exemplo de linha: 12345678000190 ou 12345678000190,5 (com limite de inscrições)';

    public function handle()
    {
        $filePath = $this->argument('file');
        $defaultMax = $this->option('max') ? (int) $this->option('max') : null;
        $force = $this->option('force');

        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return Command::FAILURE;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $imported = 0;
        $skipped = 0;
        $errors = 0;

        $this->info("Importando " . count($lines) . " linha(s)...");
        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) {
                $bar->advance();
                continue;
            }

            $parts = explode(',', $line);
            $document = preg_replace('/[^0-9]/', '', trim($parts[0]));
            $maxRegistrations = isset($parts[1]) ? (int) trim($parts[1]) : $defaultMax;

            $len = strlen($document);
            if ($len === 11) {
                $type = 'cpf';
            } elseif ($len === 14) {
                $type = 'cnpj';
            } else {
                $this->newLine();
                $this->warn("Documento inválido ignorado: {$parts[0]} (deve ter 11 ou 14 dígitos)");
                $errors++;
                $bar->advance();
                continue;
            }

            $existing = AthleteWhitelist::where('document', $document)->first();

            if ($existing) {
                if ($force) {
                    $existing->update(['max_registrations' => $maxRegistrations]);
                    $imported++;
                } else {
                    $skipped++;
                }
            } else {
                AthleteWhitelist::create([
                    'document'          => $document,
                    'type'              => $type,
                    'max_registrations' => $maxRegistrations,
                ]);
                $imported++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Concluído! Importados: {$imported} | Ignorados (já existiam): {$skipped} | Inválidos: {$errors}");

        return Command::SUCCESS;
    }
}
