<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class ApkController extends BaseController
{
    private $apksPath = WRITEPATH . 'uploads/apks';
    use ResponseTrait;
    public function apkList()
    {
        $apks = $this->listApks();
        if (!empty($apks)) {
            return $this->respond(['type' => 'success', 'data' => $apks]);
        } else {
            return $this->respond(['type' => 'error', 'message' => 'Backups apk not found']);
        }
    }

    public function apkUpgrade(int $versionApkProvider)
    {
        $apks = $this->listApks();
        $versionsApks = [];

        if (empty($apks)) {
            return $this->respond(['type' => 'error', 'message' => 'No se encontraron copias de seguridad de APK'], 404);
        }

        foreach ($apks as $apk) {
            $parts = explode('.', $apk);
            if (count($parts) >= 3 && is_numeric($parts[1])) {
                $versionsApks[] = intval($parts[1]);
            }
        }

        if (empty($versionsApks)) {
            return $this->respond(['type' => 'error', 'message' => 'No se encontraron versiones válidas de APK'], 404);
        }

        sort($versionsApks, SORT_NUMERIC);
        $versionApkMaxAvailable = max($versionsApks);

        if ($versionApkProvider > $versionApkMaxAvailable) {
            return $this->respond(['type' => 'error', 'message' => 'No hay una versión de APK disponible más nueva que la actual'], 400);
        }

        if ($versionApkProvider == $versionApkMaxAvailable) {
            return $this->respond(['type' => 'info', 'message' => 'La versión de APK está actualizada'], 200);
        }

        $nextVersion = $versionApkProvider;
        foreach ($versionsApks as $version) {
            if ($version > $versionApkProvider) {
                $nextVersion = $version;
                break;
            }
        }

        $apkFilename = "base.{$nextVersion}.apk";
        $apkPath = "{$this->apksPath}/{$apkFilename}";

        if (!file_exists($apkPath)) {
            return $this->respond(['type' => 'error', 'message' => 'El archivo APK para la actualización no se encuentra'], 404);
        }

        return $this->respond([
            'type' => 'success',
            'message' => 'APK disponible para descargar',
            'data' => [
                'version' => $nextVersion,
                'filename' => $apkFilename,
                'uri' => base_url(route_to('apk/download', $apkFilename))
            ]
        ], 200);
    }
    public function downloadApk($filename)
    {
        $apkPath = $this->apksPath . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($apkPath)) {
            return $this->respond(['type' => 'error', 'message' => 'El archivo APK solicitado no existe'], 404);
        }

        if (!preg_match('/^base\.\d+\.apk$/', $filename)) {
            return $this->respond(['type' => 'error', 'message' => 'Nombre de archivo no válido'], 400);
        }

        $fileSize = filesize($apkPath);
        $mimeType = 'application/vnd.android.package-archive';

        header("Content-Type: {$mimeType}");
        header("Content-Length: {$fileSize}");
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Pragma: public');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        // Desactivar el búfer de salida
        if (ob_get_level()) ob_end_clean();

        // Leer y enviar el archivo en trozos para manejar archivos grandes
        $handle = fopen($apkPath, 'rb');
        if ($handle === false) {
            return $this->respond(['type' => 'error', 'message' => 'No se pudo abrir el archivo para su lectura'], 500);
        }

        while (!feof($handle)) {
            $buffer = fread($handle, 1048576); // Leer en trozos de 1MB
            echo $buffer;
            flush();
        }

        fclose($handle);
        exit;
    }
    private function listApks()
    {
        // Format name base.1.apk, base.2.apk, base.3.apk
        if (is_dir($this->apksPath)) {
            $files = scandir($this->apksPath);

            $apkFiles = array_diff($files, array('.', '..'));
            $apkFiles = array_values($apkFiles);
            return $apkFiles;
        } else {
            return [];
        }
    }
}
