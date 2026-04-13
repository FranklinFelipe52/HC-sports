<?php

namespace App\Console\Commands;

use App\Models\AthleteWhitelist;
use Illuminate\Console\Command;

class ImportWhitelistFromCsv extends Command
{
    protected $signature = 'whitelist:import-csv
        {--cpf-file= : Caminho do CSV de CPFs (padrão: storage/cpf.csv)}
        {--cnpj-file= : Caminho do CSV de CNPJs (padrão: storage/cnpj.csv)}
        {--force : Substituir registros existentes}';

    protected $description = 'Importa CPFs (máx 1 uso) e CNPJs (máx 2 usos) para a whitelist a partir dos arquivos CSV padrão.';

    public function handle(): int
    {
        $cpfFile  = $this->option('cpf-file')  ?? storage_path('cpf.csv');
        $cnpjFile = $this->option('cnpj-file') ?? storage_path('cnpj.csv');
        $force    = $this->option('force');

        $total = ['imported' => 0, 'skipped' => 0, 'invalid' => 0];

        $this->info('--- Importando CPFs (máx 1 uso) ---');
        $this->processFile($cpfFile, maxRegistrations: 1, force: $force, stats: $total);

        $this->info('--- Importando CNPJs (máx 2 usos) ---');
        $this->processFile($cnpjFile, maxRegistrations: 2, force: $force, stats: $total);

        $this->info("Concluído! Importados: {$total['imported']} | Ignorados (já existiam): {$total['skipped']} | Inválidos: {$total['invalid']}");

        return Command::SUCCESS;
    }

    private function processFile(string $filePath, int $maxRegistrations, bool $force, array &$stats): void
    {
        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return;
        }

        $rows = array_filter(
            array_map('str_getcsv', file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)),
            fn($row) => count($row) >= 3
        );

        // Pula as 2 linhas de cabeçalho
        $rows = array_slice(array_values($rows), 2);

        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        foreach ($rows as $row) {
            $raw      = trim($row[2] ?? '');
            $document = preg_replace('/[^0-9]/', '', $raw);

            $len = strlen($document);
            if ($len === 11) {
                $type = 'cpf';
            } elseif ($len === 14) {
                $type = 'cnpj';
            } else {
                $this->newLine();
                $this->warn("Documento inválido ignorado: \"{$raw}\"");
                $stats['invalid']++;
                $bar->advance();
                continue;
            }

            $existing = AthleteWhitelist::where('document', $document)->first();

            if ($existing) {
                if ($force) {
                    $existing->update(['max_registrations' => $maxRegistrations]);
                    $stats['imported']++;
                } else {
                    $stats['skipped']++;
                }
            } else {
                AthleteWhitelist::create([
                    'document'          => $document,
                    'type'              => $type,
                    'max_registrations' => $maxRegistrations,
                ]);
                $stats['imported']++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }
}
