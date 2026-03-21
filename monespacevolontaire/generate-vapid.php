<?php
require 'vendor/autoload.php';

use Minishlink\WebPush\VAPID;

$keys = VAPID::createVapidKeys();

echo "Clé publique : " . $keys['publicKey'] . PHP_EOL;
echo "Clé privée : " . $keys['privateKey'] . PHP_EOL;
