<?php

final class AppConfig
{
    private string $socketAddress;
    private int $socketPort;

    private static ?self $instance = null;

    private function __construct()
    {
        $params = require_once('params.php');

        $this->socketAddress = $params['socket_address']
            ?? throw new RuntimeException('The "socket_address" is required')
        ;

        $this->socketPort = $params['socket_port']
            ?? throw new RuntimeException('The "socket_port" is required')
        ;
    }

    public function getSocketAddress(): string
    {
        return $this->socketAddress;
    }

    public function getSocketPort(): int
    {
        return $this->socketPort;
    }

    public static function init(): self
    {
        return self::$instance ?? new self();
    }
}