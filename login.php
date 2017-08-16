<?php
// Composer autoloader for using PRedis classes
require 'vendor/autoload.php';

// Input data
$login = 'Ivan3';
$password = '0000';

// Make a Connection
$redis = new Predis\Client('tcp://localhost:6379');

// Check if login and password exist in the DB
$userId = $redis->hget('users', $login);
if (!$userId) {
    echo 'Wrong login or password';
    die();
}
if ($redis->hget("user:$userId", 'password') !== $password) {
    echo 'Wrong login or password';
    die();
}

// Login user (set the cookie)
$auth = $redis->hget("user:$userId", 'auth');
setcookie('auth', $auth, time()+3600);
echo "userId - $userId is logged in <br/>";