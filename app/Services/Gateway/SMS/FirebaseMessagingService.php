<?php

declare(strict_types=1);

namespace App\Services\Gateway\SMS;

use Config\Firebase as FirebaseConfig;
use InvalidArgumentException;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Messaging\InvalidArgument as MessagingInvalidArgument;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Config\GatewayAvailability;
use Throwable;

use function get_debug_type;
use function is_array;
use function is_bool;
use function is_scalar;
use function json_encode;
use function trim;

class FirebaseMessagingService
{
    private readonly FirebaseConfig $config;
    private readonly GatewayAvailability $availabilityConfig;
    private readonly Messaging $messaging;

    public function __construct(?FirebaseConfig $config = null)
    {
        $this->config = $config ?? config('Firebase');
        $this->availabilityConfig = config(GatewayAvailability::class);

        $serviceAccount = $this->config->validatedServiceAccount();
        $projectId = $this->config->validatedProjectId();

        $factory = (new Factory())
            ->withProjectId($projectId)
            ->withServiceAccount($serviceAccount);

        $this->messaging = $factory->createMessaging();
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function sendToToken(string $token, string $event, array $data = []): array
    {
        $token = trim($token);
        $event = trim($event);

        if ($token === '') {
            throw new InvalidArgumentException('El token FCM no puede estar vacío.');
        }

        if ($event === '') {
            throw new InvalidArgumentException('El evento FCM no puede estar vacío.');
        }

        $payload = $this->normalizeDataPayload($event, $data);

        $message = CloudMessage::new()
            ->toToken($token)
            ->withData($payload)
            ->withAndroidConfig(
                AndroidConfig::new()->withHighMessagePriority()
            );

        try {
            $response = $this->messaging->send($message);

            return [
                'success' => true,
                'event' => $event,
                'project_id' => $this->config->validatedProjectId(),
                'message_id' => $response['name'] ?? null,
                'response' => $response,
                'requested_priority' => 'HIGH',
                'requested_ttl_seconds' => $this->availabilityConfig->fcmTtlSeconds,
                'payload_type' => 'data-only',
                'should_clear_token' => false,
                'error_code' => null,
                'error_message' => null,
            ];
        } catch (NotFound $exception) {
            return [
                'success' => false,
                'event' => $event,
                'project_id' => $this->config->validatedProjectId(),
                'message_id' => null,
                'response' => null,
                'requested_priority' => 'HIGH',
                'requested_ttl_seconds' => $this->availabilityConfig->fcmTtlSeconds,
                'payload_type' => 'data-only',
                'should_clear_token' => true,
                'error_code' => 'FCM_TOKEN_NOT_REGISTERED',
                'error_message' => $exception->getMessage(),
            ];
        } catch (MessagingInvalidArgument $exception) {
            return [
                'success' => false,
                'event' => $event,
                'project_id' => $this->config->validatedProjectId(),
                'message_id' => null,
                'response' => null,
                'requested_priority' => 'HIGH',
                'requested_ttl_seconds' => $this->availabilityConfig->fcmTtlSeconds,
                'payload_type' => 'data-only',
                'should_clear_token' => false,
                'error_code' => 'FCM_INVALID_ARGUMENT',
                'error_message' => $exception->getMessage(),
            ];
        } catch (MessagingException|FirebaseException $exception) {
            return [
                'success' => false,
                'event' => $event,
                'project_id' => $this->config->validatedProjectId(),
                'message_id' => null,
                'response' => null,
                'requested_priority' => 'HIGH',
                'requested_ttl_seconds' => $this->availabilityConfig->fcmTtlSeconds,
                'payload_type' => 'data-only',
                'should_clear_token' => false,
                'error_code' => 'FCM_SEND_ERROR',
                'error_message' => $exception->getMessage(),
            ];
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'event' => $event,
                'project_id' => $this->config->validatedProjectId(),
                'message_id' => null,
                'response' => null,
                'requested_priority' => 'HIGH',
                'requested_ttl_seconds' => $this->availabilityConfig->fcmTtlSeconds,
                'payload_type' => 'data-only',
                'should_clear_token' => false,
                'error_code' => 'FCM_UNEXPECTED_ERROR',
                'error_message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, string>
     */
    private function normalizeDataPayload(string $event, array $data): array
    {
        $payload = ['event' => $event];

        foreach ($data as $key => $value) {
            if (!is_string($key) || trim($key) === '') {
                continue;
            }

            $payload[$key] = $this->normalizeDataValue($value);
        }

        return $payload;
    }

    private function normalizeDataValue(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        if (is_array($value)) {
            return (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        throw new InvalidArgumentException(
            'No se pudo serializar un valor FCM de tipo ' . get_debug_type($value) . '.'
        );
    }
}
