<?php

declare(strict_types=1);

final class Data
{
    public function __construct(private string $remoteAddress, private int $remotePort, private string $data)
    {
    }

    public function getRemoteAddress(): string
    {
        return $this->remoteAddress;
    }

    public function getRemotePort(): int
    {
        return $this->remotePort;
    }

    public function getData(): string
    {
        return $this->data;
    }
}