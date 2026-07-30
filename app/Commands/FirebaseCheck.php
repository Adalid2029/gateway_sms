<?php

declare(strict_types=1);

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

class FirebaseCheck extends BaseCommand
{
    protected $group = 'Gateway SMS';
    protected $name = 'firebase:check';
    protected $description = 'Valida la configuración Firebase cargada por CodeIgniter.';

    public function run(array $params): void
    {
        try {
            $config = config('Firebase');

            CLI::write('Firebase configurado correctamente.', 'green');
            CLI::write('Project ID: ' . $config->validatedProjectId());
            CLI::write('Credentials: ' . $config->validatedCredentialsPath());
        } catch (Throwable $exception) {
            CLI::error('La configuración de Firebase no es válida.');
            CLI::error($exception->getMessage());
            $this->showError($exception);
        }
    }
}
