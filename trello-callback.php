<?php

require_once "vendor/autoload.php";

use alexshent\tbot\{Config, TelegramBotClient};

$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('trello.txt', print_r($data, 1)."\n", FILE_APPEND);

$actionType = $data['action']['type'];
$translationKey = $data['action']['display']['translationKey'];
$card = $data['action']['data']['card']['name'];
$listBefore = $data['action']['data']['listBefore']['name'];
$listAfter = $data['action']['data']['listAfter']['name'];

if ($actionType === 'updateCard' && $translationKey === 'action_move_card_from_list_to_list') {
    $client = new TelegramBotClient();
    $chatId = Config::TELEGRAM_GROUP_CHAT_ID;
    $text = "card $card moved from $listBefore to $listAfter";
    $client->sendMessage($chatId, $text);
}
