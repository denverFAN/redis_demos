<?php
// Composer autoloader for using PRedis classes
require 'vendor/autoload.php';

// Input data
$login = 'Ivan3';
$password = '0000';

// Make a Connection
$redis = new Predis\Client('tcp://localhost:6379');

// Check if login is available
if ($redis->hget('users', $login)) {
    echo 'This login is already taken';
    die();
}

// Add input data to DB, generate auth token
$userId = $redis->incr('userId');
$auth = random_int(1000, 9999);
$redis->hset('users', $login, $userId);
$redis->hmset("user:$userId", [
    'login' => $login,
    'password' => $password,
    'auth' => $auth,
]);
// Add auth token for the next checking if user is logged in
$redis->hset('auths', $auth, $userId);
echo "login - $login with userId - $userId added to database successfully <br/>";








