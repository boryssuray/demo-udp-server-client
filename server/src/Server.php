<?php

declare(strict_types=1);

require_once('Data.php');

final class Server
{
    const MAX_DATA_SIZE_BYTES = 512;

    public function __construct(
        private Socket $socket,
        private string $address,
        private int $port
    ) {}

    /**
     * @throws RuntimeException
     */
    public function bindSocket(): void
    {
        if ( ! socket_bind($this->socket, $this->address, $this->port)) {
            $this->handleSocketError();
        }
    }

    /**ß
     * @throws RuntimeException
     */
    public function receive(int $maxSizeBytes = self::MAX_DATA_SIZE_BYTES): Data
    {
        $bytesReceived = socket_recvfrom(
            $this->socket,
            $data,
            $maxSizeBytes,
            0,
            $remoteIP,
            $remotePort
        );

        if ($bytesReceived === false) {
            $this->handleSocketError();
        }

        return new Data($remoteIP, $remotePort, $data);
    }

    public function reply(Data $data): void
    {
        $this->guardAgainstDataTooLong($data);

        socket_sendto(
            $this->socket,
            $data->getData(),
            self::MAX_DATA_SIZE_BYTES,
            0,
            $data->getRemoteAddress(),
            $data->getRemotePort()
        );
    }

    private function handleSocketError(): void
    {
        $errorCode = socket_last_error();
        $errorMessage = socket_strerror($errorCode);

        throw new RuntimeException($errorMessage, $errorCode);
    }

    private function guardAgainstDataTooLong(Data $data): void
    {
        if (strlen($data->getData()) > self::MAX_DATA_SIZE_BYTES) {
            throw new RuntimeException(
                'Maximum allowed data length is ' . self::MAX_DATA_SIZE_BYTES .' bytes'
            );
        }
    }
}