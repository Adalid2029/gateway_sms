<?php

namespace App\Services\Gateway\SMS;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Throwable;

class DeviceStatusService
{
    public const STATUS_ONLINE = 'ONLINE';
    public const STATUS_DELAYED = 'DELAYED';
    public const STATUS_OFFLINE = 'OFFLINE';
    public const STATUS_SERVICE_STOPPED = 'SERVICE_STOPPED';
    public const STATUS_SERVICE_ERROR = 'SERVICE_ERROR';
    public const STATUS_CONFIGURATION_INCOMPLETE = 'CONFIGURATION_INCOMPLETE';
    public const STATUS_CONFIGURATION_ERROR = 'CONFIGURATION_ERROR';
    public const STATUS_NETWORK_ERROR = 'NETWORK_ERROR';
    public const STATUS_SIM_ERROR = 'SIM_ERROR';
    public const STATUS_DISABLED = 'DISABLED';

    private const ONLINE_THRESHOLD_SECONDS = 120;
    private const DELAYED_THRESHOLD_SECONDS = 300;

    public function determineStatus(
        array $device,
        ?DateTimeInterface $currentTime = null
    ): array {
        $timezone = $this->getApplicationTimezone();
        $now = $this->normalizeCurrentTime($currentTime, $timezone);

        if ((int) ($device['activo'] ?? 0) !== 1) {
            return $this->result(
                self::STATUS_DISABLED,
                'El dispositivo está deshabilitado',
                'danger',
                null
            );
        }

        $lastHeartbeat = $this->parseDeviceDateTime(
            $device['ultimo_latido_en'] ?? null,
            $timezone
        );

        if ($lastHeartbeat === null) {
            return $this->result(
                self::STATUS_OFFLINE,
                'El dispositivo no tiene un heartbeat válido registrado',
                'danger',
                null
            );
        }

        $secondsAgo = max(0, $now->getTimestamp() - $lastHeartbeat->getTimestamp());

        if ($secondsAgo > self::DELAYED_THRESHOLD_SECONDS) {
            return $this->result(
                self::STATUS_OFFLINE,
                'El último heartbeat es demasiado antiguo',
                'danger',
                $secondsAgo
            );
        }

        if ($secondsAgo > self::ONLINE_THRESHOLD_SECONDS) {
            return $this->result(
                self::STATUS_DELAYED,
                'El heartbeat del dispositivo presenta retraso',
                'warning',
                $secondsAgo
            );
        }

        $serviceState = $this->normalizeEnum($device['estado_servicio'] ?? null);
        $configurationState = $this->normalizeEnum($device['estado_configuracion'] ?? null);
        $networkType = $this->normalizeEnum($device['tipo_red'] ?? null);
        $networkValidated = $this->normalizeNullableBooleanInt(
            $device['red_validada'] ?? null
        );
        $simAvailable = array_key_exists('sim_disponible', $device)
            ? $this->normalizeNullableBooleanInt($device['sim_disponible'])
            : null;

        if ($serviceState === 'ERROR') {
            return $this->result(
                self::STATUS_SERVICE_ERROR,
                'El servicio Android reporta un error',
                'danger',
                $secondsAgo
            );
        }

        if ($serviceState === 'STOPPED') {
            return $this->result(
                self::STATUS_SERVICE_STOPPED,
                'El servicio Android está detenido',
                'danger',
                $secondsAgo
            );
        }

        if ($serviceState === 'STARTING') {
            return $this->result(
                self::STATUS_DELAYED,
                'El servicio Android aún se está iniciando',
                'warning',
                $secondsAgo
            );
        }

        if ($configurationState === 'ERROR') {
            return $this->result(
                self::STATUS_CONFIGURATION_ERROR,
                'La configuración del dispositivo contiene errores',
                'danger',
                $secondsAgo
            );
        }

        if ($configurationState === 'INCOMPLETE') {
            return $this->result(
                self::STATUS_CONFIGURATION_INCOMPLETE,
                'La configuración del dispositivo está incompleta',
                'warning',
                $secondsAgo
            );
        }

        if (
            $networkType === 'NONE'
            || $networkValidated === 0
        ) {
            return $this->result(
                self::STATUS_NETWORK_ERROR,
                'El dispositivo no tiene una conexión de red validada',
                'danger',
                $secondsAgo
            );
        }

        if (
            $serviceState === 'RUNNING'
            && array_key_exists('sim_disponible', $device)
            && $simAvailable === 0
        ) {
            return $this->result(
                self::STATUS_SIM_ERROR,
                'El dispositivo no tiene una SIM disponible',
                'danger',
                $secondsAgo
            );
        }

        if (
            in_array($serviceState, ['', 'UNKNOWN'], true)
            || in_array($configurationState, ['', 'UNKNOWN'], true)
            || in_array($networkType, ['', 'UNKNOWN'], true)
            || $networkValidated === null
            || (array_key_exists('sim_disponible', $device) && $simAvailable === null)
        ) {
            return $this->result(
                self::STATUS_DELAYED,
                'El diagnóstico del dispositivo aún está incompleto',
                'warning',
                $secondsAgo
            );
        }

        return $this->result(
            self::STATUS_ONLINE,
            'El dispositivo está funcionando correctamente',
            'success',
            $secondsAgo
        );
    }

    private function result(
        string $status,
        string $message,
        string $severity,
        ?int $secondsAgo
    ): array {
        return [
            'status' => $status,
            'message' => $message,
            'severity' => $severity,
            'is_online' => $status === self::STATUS_ONLINE,
            'requires_attention' => $severity !== 'success',
            'last_heartbeat_seconds_ago' => $secondsAgo,
            'thresholds' => [
                'online_seconds' => self::ONLINE_THRESHOLD_SECONDS,
                'delayed_seconds' => self::DELAYED_THRESHOLD_SECONDS,
            ],
        ];
    }

    private function getApplicationTimezone(): DateTimeZone
    {
        $timezone = config('App')->appTimezone;

        return new DateTimeZone($timezone);
    }

    private function normalizeCurrentTime(
        ?DateTimeInterface $currentTime,
        DateTimeZone $timezone
    ): DateTimeImmutable {
        if ($currentTime === null) {
            return new DateTimeImmutable('now', $timezone);
        }

        return DateTimeImmutable::createFromInterface($currentTime)
            ->setTimezone($timezone);
    }

    private function parseDeviceDateTime(
        mixed $value,
        DateTimeZone $timezone
    ): ?DateTimeImmutable {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        try {
            return new DateTimeImmutable(trim($value), $timezone);
        } catch (Throwable) {
            return null;
        }
    }

    private function normalizeEnum(mixed $value): string
    {
        if (!is_string($value)) {
            return '';
        }

        return strtoupper(trim($value));
    }

    private function normalizeNullableBooleanInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if (is_numeric($value)) {
            return ((int) $value) === 1 ? 1 : 0;
        }

        $normalized = strtolower(trim((string) $value));

        return in_array($normalized, ['1', 'true', 'yes'], true) ? 1 : 0;
    }
}
