<?php
use React\EventLoop\Factory;
use React\Socket\Connector;
use Ratchet\Client\Connector as Client;
use Ratchet\Client\WebSocket;

require __DIR__.'/../bootstrap/autoload.php';

echo env("DB_HOST", "somedefaultvalue");

$loop = Factory::create();
$reactConnector = new Connector($loop, [
    'timeout' => 0.5
]);
$connector = new Client($loop, $reactConnector);

$connector('ws://localhost:9000')->then(function(WebSocket $conn) {
    $conn->send('Hello World!');
    $conn->close();
}, function(Exception $e) use ($loop) {
    $loop->stop();
});

$loop->run();

?>