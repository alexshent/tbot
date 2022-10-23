<?php

require_once "vendor/autoload.php";

$client = new alexshent\tbot\TelegramBotClient();
$result = $client->deleteWebhook();
print_r($result);
