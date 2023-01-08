<?php

declare(strict_types=1);

require_once('Data.php');

final class Client
{
    private const MAX_DATA_SIZE_BYTES = 512;
    private const RECEIVE_DATA_LENGTH = 2048;

    public function __construct(private Socket $socket)
    {
    }

    /**
     * @throws RuntimeException
     */
    public function send(Data $data): void
    {
        $this->guardAgainstDataTooLong($data);

        $sentBytes = socket_sendto(
            $this->socket,
            $data->getData(),
            strlen($data->getData()),
            0,
            $data->getRemoteAddress(),
            $data->getRemotePort()
        );

        if ($sentBytes === false) {
            $this->handleSocketError();
        }
    }

    public function receive(): ?string
    {
        $receivedBytes = socket_recv(
            $this->socket,
            $reply,
            self::RECEIVE_DATA_LENGTH,
            MSG_WAITALL)
        ;

        if ($receivedBytes === false) {
            return null;
        }

        return $reply;
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
                'Maximum allowed data length is ' . self::MAX_DATA_SIZE_BYTES . 'bytes'
            );
        }
    }
}