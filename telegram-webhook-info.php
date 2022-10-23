<?php

require_once "vendor/autoload.php";

$client = new alexshent\tbot\TelegramBotClient();
$result = $client->getWebhookInfo();
print_r($result);
