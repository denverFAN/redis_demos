<?php
// Composer autoloader for using PRedis classes
require 'vendor/autoload.php';

// Make a Connection
$redis = new Predis\Client('tcp://localhost:6379');
echo "Connection to database successfully \n";

// set a value to a particular key
$redis->set("username", "Ivan");
$redis->set("age", "25");

// retrieves the value for the key
$value = $redis->get("username");

// reports back whether the provided key is found or not in Redis’ storage
echo ($redis->exists("username")) ? "true \n" : "false \n";

// increment/decrement values (by 1)
$redis->incr("age");
$redis->decr("age");

// increment/decrement values (by interval)
$redis->incrby("age", 5);
$redis->decrby("age", 3);

// work with Redis’ HASH data type – a map of string keys and string values
// set the value for a key on the hash object
$redis->hset("profile", "firstname", "Ivan");
$redis->hset("profile", "lastname", "Tsygan");
// mass assign several key-values to a hash
$redis->hmset("personalInfo", [
    "gender" => "Male",
    "maritalStatus" => 1,
]);
// get the value for a key on the hash object
$value = $redis->hget("personalInfo", "gender");
echo "Gender: $value \n";
// remove a key from the object
$redis->hdel("profile", "lastname");
// increment the value for a key of the hash object with a specified value
$redis->hincrby("personalInfo", "maritalStatus", 1);
// get all keys and data for a object
$values = $redis->hgetall("personalInfo");
echo "<pre>";
var_dump($values);
echo "</pre>";

// work with Redis’ LIST data type – a simple list of strings order by the insertion of its elements
$key = "Skills List";
// append element(s) to a list
$redis->rpush($key, "PHP");
// prepend element(s) to a list
$redis->lpush($key, "MySQL");
// get the length of a list
$length = $redis->llen($key);
echo "Number of skills in list: $length \n";
// get elements from a list (0, -1 - return all elements)
$elements = $redis->lrange($key, 0, -1);
echo "<pre>";
var_dump($elements);
echo "</pre>";
// remove and retrieve the first element of a list
$firstElement = $redis->lpop($key);
echo $firstElement."\n";
// remove and retrieve the last element of a list
$lastElement = $redis->rpop($key);
echo $lastElement."\n";

// commands to handle data persistence
// set an expiration timeout (in seconds) for a key after which it and its value will be deleted.
$redis->expire("age", 3600);
// set an expiration time using a unix timestamp that represents when the key and value will be deleted
$redis->expireat("age", strtotime("+1 week"));
// get the remaining time (in seconds) left to live for a key with an expiration
$timeToLive = $redis->ttl("age");
echo $timeToLive."\n";
// remove the expiration on the given key
$redis->persist("age");











