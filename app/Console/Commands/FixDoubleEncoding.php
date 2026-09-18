<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Répare les textes doublement encodés en UTF-8.
 *
 * Symptôme : « Exaucé » stocké sous la forme « ExaucÃ© ». Les octets UTF-8 de
 * « é » (c3a9) ont été relus comme du latin-1 (« Ã© ») puis réencodés en UTF-8
 * (c383 c2a9). C'est le cas quand un dump SQL est importé avec un mauvais
 * charset client.
 */
class FixDoubleEncoding extends Command
{
    protected $signature = 'healthpass:fix-encoding
                            {--apply : Écrit les corrections (sans cette option, simple aperçu)}';

    protected $description = 'Détecte et répare les textes doublement encodés en UTF-8';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');
        $found = 0;
        $fixed = 0;

        foreach ($this->textColumns() as [$table, $column]) {
            $values = DB::table($table)
                ->whereRaw("`$column` REGEXP 'Ã|Â|â€'")
                ->distinct()
                ->pluck($column);

            foreach ($values as $value) {
                $repaired = $this->repair($value);
                if ($repaired === null) {
                    continue;
                }

                $found++;
                $this->line(sprintf(
                    '  <comment>%s.%s</comment>  %s → %s',
                    $table,
                    $column,
                    $this->preview($value),
                    $this->preview($repaired)
                ));

                if ($apply) {
                    $fixed += DB::table($table)
                        ->where($column, $value)
                        ->update([$column => $repaired]);
                }
            }
        }

        if ($found === 0) {
            $this->info('Aucun texte doublement encodé trouvé.');

            return self::SUCCESS;
        }

        $this->newLine();

        if ($apply) {
            $this->info("$found valeur(s) distincte(s) corrigée(s), $fixed ligne(s) mise(s) à jour.");
        } else {
            $this->warn("$found valeur(s) à corriger. Relancez avec --apply pour écrire les corrections.");
        }

        return self::SUCCESS;
    }

    /**
     * Rend la valeur réparée, ou null si elle n'est pas doublement encodée.
     */
    private function repair(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        $decoded = @mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');

        if ($decoded === false || $decoded === $value || ! mb_check_encoding($decoded, 'UTF-8')) {
            return null;
        }

        // Un texte réellement doublement encodé perd ses marqueurs après conversion.
        if (preg_match('/Ã|Â|â€/u', $decoded)) {
            return null;
        }

        return $decoded;
    }

    /**
     * @return list<array{0: string, 1: string}>
     */
    private function textColumns(): array
    {
        $tables = DB::select('SHOW TABLES');
        $key = $tables ? array_keys((array) $tables[0])[0] : null;
        $columns = [];

        foreach ($tables as $row) {
            $table = ((array) $row)[$key];

            if (in_array($table, ['migrations', 'sessions', 'cache', 'cache_locks', 'jobs'], true)) {
                continue;
            }

            foreach (DB::select("SHOW COLUMNS FROM `$table`") as $column) {
                if (preg_match('/char|text/i', $column->Type)) {
                    $columns[] = [$table, $column->Field];
                }
            }
        }

        return $columns;
    }

    private function preview(string $value): string
    {
        $value = preg_replace('/\s+/u', ' ', $value);

        return mb_strlen($value) > 60 ? mb_substr($value, 0, 60).'…' : $value;
    }
}
