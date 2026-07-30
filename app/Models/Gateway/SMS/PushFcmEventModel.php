<?php

declare(strict_types=1);

namespace App\Models\Gateway\SMS;

use CodeIgniter\Model;

class PushFcmEventModel extends Model
{
    protected $table            = 'evento_push_fcm_gateway';
    protected $primaryKey       = 'id_evento_push_fcm_gateway';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_dispositivo_proveedor_gateway',
        'id_user_proveedor_sms',
        'identificador_evento',
        'tipo_evento',
        'estado_envio',
        'id_mensaje_firebase',
        'codigo_error',
        'mensaje_error',
        'enviado_en',
        'recibido_en',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function createPendingEvent(
        int $deviceId,
        int $providerId,
        string $eventIdentifier,
        string $eventType
    ): ?int {
        $inserted = $this->insert([
            'id_dispositivo_proveedor_gateway' => $deviceId,
            'id_user_proveedor_sms' => $providerId,
            'identificador_evento' => $eventIdentifier,
            'tipo_evento' => $eventType,
            'estado_envio' => 'PENDIENTE',
        ], true);

        return $inserted === false ? null : (int) $inserted;
    }

    public function markAccepted(
        int $eventId,
        string $firebaseMessageId,
        string $serverTime
    ): bool {
        return $this->update($eventId, [
            'estado_envio' => 'ACEPTADO_FCM',
            'id_mensaje_firebase' => $firebaseMessageId,
            'enviado_en' => $serverTime,
        ]);
    }

    public function markReceived(
        int $eventId,
        string $serverTime
    ): bool {
        return $this->update($eventId, [
            'estado_envio' => 'RECIBIDO_DISPOSITIVO',
            'recibido_en' => $serverTime,
        ]);
    }

    public function markError(
        int $eventId,
        string $errorCode,
        string $errorMessage,
        ?string $serverTime = null
    ): bool {
        $data = [
            'estado_envio' => 'ERROR',
            'codigo_error' => $errorCode,
            'mensaje_error' => mb_substr($errorMessage, 0, 500),
        ];

        if ($serverTime !== null) {
            $data['enviado_en'] = $serverTime;
        }

        return $this->update($eventId, $data);
    }

    public function findByIdentifier(string $eventIdentifier): ?array
    {
        return $this->where('identificador_evento', $eventIdentifier)->first();
    }
}
