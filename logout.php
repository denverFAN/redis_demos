<?php
// Composer autoloader for using PRedis classes
require 'vendor/autoload.php';

// Make a Connection
$redis = new Predis\Client('tcp://localhost:6379');

if (!empty($_COOKIE['auth'])) {
    $userId = $redis->hget('auths', $_COOKIE['auth']);
    $auth = $redis->hget("user:$userId", 'auth');
    if ($auth == $_COOKIE['auth']) {
        // Change auth token for the current user
        $newAuth = random_int(1000, 9999);
        $redis->hset("user:$userId", 'auth', $newAuth);
        $redis->hdel('auths', $auth);
        $redis->hset('auths', $newAuth, $userid);
        echo "userId - $userId is logged out <br/>";
    }
}