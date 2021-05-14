<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

echo __FILE__ . PHP_EOL;
echo __DIR__ . PHP_EOL;
echo dirname(__FILE__) . PHP_EOL;
echo dirname(dirname(__FILE__)) . PHP_EOL;

include __DIR__ . 'public/hello-world.php';

