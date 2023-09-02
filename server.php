<?php

use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

require_once __DIR__ . '/vendor/autoload.php';




$hostname = 'localhost';
$DB_NAME = 'db_sheep';
$DB_USER = 'admin@tar';
$DB_PASS = 'P@ssw0rd0979284920';
$conn = new mysqli($hostname, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$context = array(
    'ssl' => array(
        'local_cert'  => '/certificate.pfx',
        'local_pk'    => '/sheep.local.key',
        'verify_peer' => false
    )
);
// Listen port 2021 for socket.io client
$io = new SocketIO(2022);
$io->on('connection', function ($socket) use ($io, $conn) {

    $socket->on('newmessage', function ($data) use ($io, $socket, $conn) {
        $data1 = $conn->query("SELECT * db_sheep.personaldocument WHERE pd_id = 3")->fetch_array();
        echo '<pre>';
        print_r($data1);
        $io->emit('response', (['data' =>  $data1]));
    });

    // $socket->on('receive order', function ($msg) use ($io, $conn) {

    //     $response = json_decode($msg);
    //     $result = $conn->query("s");
    //     $data = $result->fetchAll();

    //     $io->emit('send order', json_encode([
    //         'merchant_id' => $data[0]['merchant_id'],
    //         'id' => $response->last_id
    //     ]));
    // });
});

Worker::runAll();
