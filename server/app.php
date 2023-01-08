<?php

declare(strict_types=1);

require_once('src/SocketFactory.php');
require_once('src/Server.php');
require_once('config/AppConfig.php');

try {
    $socket = SocketFactory::create();

    $appConfig = AppConfig::init();

    $server = new Server(
        $socket,
        $appConfig->getSocketAddress(),
        $appConfig->getSocketPort()
    );

    $server->bindSocket();

    echo sprintf(
        'UDP socket is bound to %s on port %d...%s',
        $appConfig->getSocketAddress(),
        $appConfig->getSocketPort(),
        PHP_EOL
    );

    while (true) {
        $data = $server->receive();

        echo sprintf(
            'Received message "%s" from "%s:%d"%s',
            trim($data->getData()),
            $data->getRemoteAddress(),
            $data->getRemotePort(),
            PHP_EOL
        );

        $server->reply(new Data(
            $data->getRemoteAddress(),
            $data->getRemotePort(),
            'OK' . PHP_EOL
        ));
    }
} catch (RuntimeException $e) {
    die ("App failed with" . $e->getMessage());
}