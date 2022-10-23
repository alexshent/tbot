<?php

use alexshent\tbot\TrelloClient;

require_once "vendor/autoload.php";

$boardId = Config::TRELLO_BOARD_ID;

$client = new TrelloClient();

// $result = $client->getBoards();
// print_r($result);

// $result = $client->createList($boardId, 'InProgress');
// print_r($result);
// $result = $client->createList($boardId, 'Done');
// print_r($result);

// $callbackURL = 'https://yahdoozi.000webhostapp.com/tbot/trello-callback.php';
// $idModel = $boardId;
// $result = $client->createWebhook($callbackURL, $idModel);
// print_r($result);
