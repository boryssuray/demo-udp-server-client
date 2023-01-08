<?php

declare(strict_types=1);

final class SocketFactory
{
    /**
     * @throws RuntimeException
     */
    public static function create(): Socket
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if (! $socket) {
            $errorCode = socket_last_error();
            $errorMessage = socket_strerror($errorCode);

            throw new RuntimeException($errorMessage, $errorCode);
        }

        return $socket;
    }
}