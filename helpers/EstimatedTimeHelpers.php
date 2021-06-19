<?php

namespace app\helpers;

class EstimatedTimeHelpers
{
    public static function estimatedTimeFromParts(array $parts): int
    {
        [$days, $hours, $minutes] = $parts;
        return ($days * 24 + $hours) * 60 + $minutes;
    }

    public static function estimatedTimeToParts(int $time): array
    {
        $days = floor($time / 60 / 24);
        $hours = floor($time / 60 - $days * 24);
        $minutes = $time - ($days * 24 + $hours) * 60;

        return [$days, $hours, $minutes];
    }

    public static function toReadableEstimatedTime(array|int $time): string
    {
        [$days, $hours, $minutes] = is_int($time)
            ? self::estimatedTimeToParts($time)
            : $time;

        if ($days > 0) {
            return "${days}d ${hours}h ${minutes}m";
        }

        if ($hours > 0) {
            return "${hours}h ${minutes}m";
        }

        return "${minutes}m";
    }
}