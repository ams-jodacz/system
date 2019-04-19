<?php
use React\EventLoop\Factory;
use React\Socket\Connector;
use Ratchet\Client\Connector as Client;
use Ratchet\Client\WebSocket;
use App\Helper\Socket;

require __DIR__.'/../bootstrap/autoload.php';

$host = Socket::getHost();
$port = Socket::getPort();

$loop = Factory::create();
$reactConnector = new Connector($loop, [
    'timeout' => 0.5
]);
$connector = new Client($loop, $reactConnector);

$connector('ws://'.$host.':'.$port)->then(function(WebSocket $conn) {
    $conn->send('Hello World!');
    $conn->close();
}, function(Exception $e) use ($loop) {
    $loop->stop();
});

$loop->run();

?>