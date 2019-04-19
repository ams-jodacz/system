<?php
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use App\Http\Controllers\Server as Server;
use App\Helper\Socket;

require __DIR__.'/../bootstrap/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server()
        )
    ),
    Socket::getPort()
);

$server->run();

?>