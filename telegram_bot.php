<?php

require_once "vendor/autoload.php";
require_once 'bootstrap.php';

use alexshent\tbot\{Config, TelegramBotClient, TrelloClient};
use alexshent\tbot\entities\User;

$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('telegram-in.txt', print_r($data, 1)."\n", FILE_APPEND);

$chatType = $data['message']['chat']['type'];
$chatId = $data['message']['chat']['id'];

$userId = $data['message']['from']['id'];
$firstName = $data['message']['from']['first_name'];
$username = $data['message']['from']['username'];

$text = $data['message']['text'];

if ($chatType === 'private') {
} else if ($chatType === 'group') {
    $chatTitle = $data['message']['chat']['title'];
}

$handlers = [];

// ----------------------------------

$handlers['start'] = function($items) {
    global $chatType, $chatId;
    global $entityManager;

    $client = new TelegramBotClient();

    if ($chatType === 'private') {
        // private chat
        global $userId, $firstName, $username;

        $client->sendMessage($chatId, "hello $firstName");

        // save new user
        $user = $entityManager->find('alexshent\tbot\entities\User', $userId);
        if ($user == null) {
            $user = new User();
            $user->setId($userId);
            $user->setFirstName($firstName);
            $user->setUsername($username);
            $entityManager->persist($user);
            $entityManager->flush();
        }
    } else if ($chatType === 'group') {
        // group chat
        global $chatTitle;

        $reportButton = [
            'text' => '/report'
        ];
        $replyMarkup = [
            'keyboard' => [[$reportButton]],
            'resize_keyboard' => true
        ];

        $client->sendMessage($chatId, "hello $chatTitle", $replyMarkup);
    }
};

// ----------------------------------

$handlers['trello'] = function($items) {
    global $userId, $chatId;
    global $entityManager;

    // add trello account for user
    $trelloUsername = $items[1];
    if (!empty($trelloUsername)) {
        $user = $entityManager->find('alexshent\tbot\entities\User', $userId);
        if ($user) {
            $user->setTrelloUsername($trelloUsername);
            $entityManager->persist($user);
            $entityManager->flush();

            $client = new TelegramBotClient();
            $client->sendMessage($chatId, "trello username saved");
        }
    }
};

// ----------------------------------

$handlers['debug'] = function($items) {
    global $chatId;
    global $entityManager;

    $users = $entityManager->getRepository('alexshent\tbot\entities\User')->findAll();
    $client = new TelegramBotClient();
    $client->sendMessage($chatId, print_r($users, true));
};

// ----------------------------------

$handlers['report'] = function($items) {
    global $entityManager;

    $membersInProgressTasks = [];

    $trelloClient = new TrelloClient();
    $boardId = Config::TRELLO_BOARD_ID;

    $telegramBotClient = new TelegramBotClient();

    // get in progress list
    $inProgressList = null;
    $lists = json_decode($trelloClient->getListsOnBoard($boardId));
    foreach ($lists as $list) {
        if ($list->name === 'InProgress') {
            $inProgressList = $list;
            break;
        }
    }

    // get cards of in progress list
    $inProgressCards = json_decode($trelloClient->getCardsInList($inProgressList->id));
    // calc in-progress tasks number for card members
    foreach ($inProgressCards as $card) {
        foreach ($card->idMembers as $memberId) {
            if (array_key_exists($memberId, $membersInProgressTasks)) {
                $membersInProgressTasks[$memberId] ++;
            } else {
                $membersInProgressTasks[$memberId] = 1;
            }
        }
    }

    $members = [];
    foreach ($membersInProgressTasks as $key => $value) {
        $member = json_decode($trelloClient->getMember($key));
        $member->tasksInProgress = $value;
        $members[] = $member;
    }

    $result = [];
    $resultString = "trello user : tasks in progress\n";
    $resultString .= "------------------------------\n";
    foreach ($members as $member) {
        // filter for registered users only
        $query = $entityManager->createQuery('SELECT u FROM alexshent\tbot\entities\User u WHERE u.trelloUsername = ' . "'{$member->username}'");
        $persistedUser = $query->getOneOrNullResult();

        if ($persistedUser) {
            $user = new stdClass();
            $user->username = $member->username;
            $user->tasksInProgress = $member->tasksInProgress;
            $result[] = $user;
            $resultString .= "{$user->username} : {$user->tasksInProgress}\n";
        }
    }

    $chatId = Config::TELEGRAM_GROUP_CHAT_ID;
    $telegramBotClient->sendMessage($chatId, $resultString);
};

// =================================

// check if message is a bot command
if (preg_match('/\/[a-zA-z]+.*/', $text) === 1) {
    $items = explode(" ", $text);
    $command = mb_strtolower(ltrim($items[0], '/'), 'UTF-8');
    if (array_key_exists($command, $handlers)) {
        $handler = $handlers[$command];
        if (is_callable($handler)) {
            $handler($items);
        }
    }
}
