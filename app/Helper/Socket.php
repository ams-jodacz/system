<?php
namespace App\Helper;
use React\EventLoop\Factory;
use React\Socket\Connector;
use Ratchet\Client\Connector as Client;
use Ratchet\Client\WebSocket;

class Socket {
    public static function sendData($info){
        $loop = Factory::create();
        $reactConnector = new Connector($loop, [
            'timeout' => 0.5
        ]);
        $connector = new Client($loop, $reactConnector);

        $connector('ws://localhost:9000')->then(function(WebSocket $conn) use ($info){
            $conn->send($info);
            $conn->close();
        }, function(Exception $e) use ($loop) {
            $loop->stop();
        });

        $loop->run();
    }
}

?>