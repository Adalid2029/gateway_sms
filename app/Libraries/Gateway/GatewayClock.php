<?php

namespace App\Libraries\Gateway;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class GatewayClock
{
    private const DATABASE_FORMAT = 'Y-m-d H:i:s';
    private const GATEWAY_TIMEZONE = 'America/La_Paz';

    public static function timezone(): DateTimeZone
    {
        return new DateTimeZone(self::GATEWAY_TIMEZONE);
    }

    public static function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', self::timezone());
    }

    public static function nowDatabase(): string
    {
        return self::formatDatabase(self::now());
    }

    public static function secondsAgo(int $seconds): string
    {
        return self::formatDatabase(self::now()->sub(new DateInterval('PT' . max(0, $seconds) . 'S')));
    }

    public static function secondsFromNow(int $seconds): string
    {
        return self::formatDatabase(self::now()->add(new DateInterval('PT' . max(0, $seconds) . 'S')));
    }

    public static function parseDatabase(?string $value): ?DateTimeImmutable
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $parsed = DateTimeImmutable::createFromFormat(
            '!' . self::DATABASE_FORMAT,
            trim($value),
            self::timezone()
        );

        return $parsed === false ? null : $parsed;
    }

    public static function formatDatabase(DateTimeInterface $dateTime): string
    {
        return DateTimeImmutable::createFromInterface($dateTime)
            ->setTimezone(self::timezone())
            ->format(self::DATABASE_FORMAT);
    }
}
