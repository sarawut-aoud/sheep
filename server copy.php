<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


require dirname(__DIR__) . '/sheep/vendor/autoload.php';
require dirname(__DIR__) . '/sheep/connectWs.php';


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ConnectionWs()
        )
    ),
    3000
);

$server->run();
