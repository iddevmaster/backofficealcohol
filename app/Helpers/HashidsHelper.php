<?php

namespace App\Helpers;

use Hashids\Hashids;

class HashidsHelper
{
    private static ?Hashids $instance = null;

    /**
     * Get the singleton Hashids instance with app key as salt and length 10.
     */
    private static function getInstance(): Hashids
    {
        if (self::$instance === null) {
            self::$instance = new Hashids(config('app.key', 'backofficealcohol'), 10);
        }
        return self::$instance;
    }

    /**
     * Encode an integer ID into a Hashids string.
     */
    public static function encode(int $id): string
    {
        return self::getInstance()->encode($id);
    }

    /**
     * Decode a Hashids string back into an integer ID.
     */
    public static function decode(string $hash): ?int
    {
        $decoded = self::getInstance()->decode($hash);
        return !empty($decoded) ? $decoded[0] : null;
    }
}
