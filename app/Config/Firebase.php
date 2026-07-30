<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;
use RuntimeException;

use function is_array;
use function is_readable;
use function json_decode;
use function realpath;
use function str_starts_with;
use function trim;

class Firebase extends BaseConfig
{
    public string $projectId;
    public string $credentialsPath;

    public function __construct()
    {
        parent::__construct();

        $this->projectId = trim((string) env('FIREBASE_PROJECT_ID', ''));
        $this->credentialsPath = trim((string) env('FIREBASE_CREDENTIALS', ''));
    }

    public function validatedProjectId(): string
    {
        if ($this->projectId === '') {
            throw new RuntimeException('FIREBASE_PROJECT_ID no está configurado.');
        }

        return $this->projectId;
    }

    public function validatedCredentialsPath(): string
    {
        if ($this->credentialsPath === '') {
            throw new RuntimeException('FIREBASE_CREDENTIALS no está configurado.');
        }

        $resolvedPath = realpath($this->credentialsPath);
        if ($resolvedPath === false) {
            throw new RuntimeException('No se encontró el archivo de credenciales de Firebase.');
        }

        if (!is_readable($resolvedPath)) {
            throw new RuntimeException('El archivo de credenciales de Firebase no es legible.');
        }

        $publicPath = realpath(FCPATH);
        if ($publicPath !== false && str_starts_with($resolvedPath, $publicPath)) {
            throw new RuntimeException('Las credenciales de Firebase no pueden estar dentro de public/.');
        }

        return $resolvedPath;
    }

    /**
     * @return array<string, mixed>
     */
    public function validatedServiceAccount(): array
    {
        $credentialsPath = $this->validatedCredentialsPath();
        $contents = file_get_contents($credentialsPath);

        if ($contents === false) {
            throw new RuntimeException('No se pudo leer el JSON de credenciales de Firebase.');
        }

        $decoded = json_decode($contents, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('El JSON de credenciales de Firebase no es válido.');
        }

        foreach (['type', 'project_id', 'client_email', 'private_key'] as $requiredKey) {
            if (empty($decoded[$requiredKey])) {
                throw new RuntimeException(
                    sprintf(
                        'El JSON de credenciales de Firebase no contiene "%s".',
                        $requiredKey
                    )
                );
            }
        }

        if ($decoded['type'] !== 'service_account') {
            throw new RuntimeException('El archivo de credenciales no corresponde a una cuenta de servicio.');
        }

        if ($decoded['project_id'] !== $this->validatedProjectId()) {
            throw new RuntimeException('El project_id del JSON no coincide con FIREBASE_PROJECT_ID.');
        }

        return $decoded;
    }
}
