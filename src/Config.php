<?php

namespace alexshent\tbot;

class Config {
    
    const DB_CONNECTION = [
        'driver'   => 'pdo_mysql',
        'host' => '172.17.0.3',
        'user'     => 'bot_user',
        'password' => '1',
        'dbname'   => 'bot_db',
        'charset' => 'utf8mb4'
    ];

    const TELEGRAM_TOKEN = '5727240837:AAFu8_aZAgX9EgK4Ptd61CLZvMh8mAzxMwQ';
    const TELEGRAM_GROUP_CHAT_ID = -886259514;

    const TRELLO_KEY = 'ce607869ef0bf4fa54f16899ad30cd63';
    const TRELLO_TOKEN = '6ad7efffe218d80d7ee9f5bc551f1c163ea987e0109356d37615fb905dcf9cd4';
    const TRELLO_BOARD_ID = '63494660032ad40203329afa';
}
