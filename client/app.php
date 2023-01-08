<?php

declare(strict_types=1);

require_once('src/SocketFactory.php');
require_once('src/Client.php');
require_once('config/AppConfig.php');

try {
    $socket = SocketFactory::create();

    $client = new Client($socket);

    $appConfig = AppConfig::init();

    while (true) {
        echo 'Enter message: ';
        $input = fgets(STDIN);

        $client->send(new Data(
            $appConfig->getSocketAddress(),
            $appConfig->getSocketPort(),
            $input
        ));

        $reply = $client->receive();
        if ($reply !== null) {
            echo 'Reply: ' . $reply . PHP_EOL;
        }
    }
} catch (RuntimeException $e) {
    die ("App failed with" . $e->getMessage());
}
