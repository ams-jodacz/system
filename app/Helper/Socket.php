<?php
namespace App\Helper;
use React\EventLoop\Factory;
use React\Socket\Connector;
use Ratchet\Client\Connector as Client;
use Ratchet\Client\WebSocket;
use App\Http\Controllers\Server;
use URL;
use Request;

class Socket {
    public static function sendData($info){
        $host = Socket::getHost();
        $port = Socket::getPort();

        $loop = Factory::create();
        $reactConnector = new Connector($loop, [
            'timeout' => 0.5
        ]);
        $connector = new Client($loop, $reactConnector);

        $connector('ws://'.$host.':'.$port)->then(function(WebSocket $conn) use ($info){
            $conn->send($info);
            $conn->close();
        }, function(Exception $e) use ($loop) {
            $loop->stop();
        });

        $loop->run();
    }

    public static function getPort(){
        return 9000;
    }

    public static function getHost(){
        // $path = Request::url();
        // $current_url = str_replace('http://','',str_replace('https://','',URL::to('/')));
        // $current_url = str_replace($path,'',$current_url);
        // $current_url = str_replace('public','',$current_url);
        // $current_url = str_replace('/','',$current_url);
        $current_url = 'localhost';
        return $current_url;
    }
}

?>
