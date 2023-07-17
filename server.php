<?php
    use Workerman\Worker;
    use PHPSocketIO\SocketIO;
    require_once __DIR__ . '/vendor/autoload.php';

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully\n";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    // Listen port 2021 for socket.io client
    $io = new SocketIO(2021);
    $io->on('connection', function ($socket) use ($io, $conn) {
        // $socket->on('chat message', function ($msg) use ($io) {
        //     $io->emit('nice', $msg);
        // });

        $socket->on('receive order', function($msg) use ($io, $conn) {
            
            $response = json_decode($msg);
            $result = $conn->query("SELECT * FROM geerang_pos.order a WHERE a.id = $response->last_id");
            $data = $result->fetchAll();

            $io->emit('send order', json_encode([
                'merchant_id' => $data[0]['merchant_id'],
                'id' => $response->last_id
            ]));

        });

    });
    
    Worker::runAll();
?>