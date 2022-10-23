<?php

namespace alexshent\tbot;

class TelegramBotClient {

    const URL = 'https://api.telegram.org/bot' . Config::TELEGRAM_TOKEN . '/';
    private RestClient $client;

    public function __construct() {
        $this->client = new CurlClient();
    }

    // https://core.telegram.org/bots/api#sendmessage
    public function sendMessage(int $chatId, string $text, array $replyMarkup = null) {
        $url = self::URL . 'sendMessage';
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
        ];
        if ($replyMarkup) {
            $data['reply_markup'] = $replyMarkup;
        }
        $this->client->post($url, $data);
    }

    public function getWebhookInfo(): string {
        $url = self::URL . 'getWebhookInfo';
        return $this->client->get($url);
    }

    public function deleteWebhook(): string {
        $url = self::URL . 'deleteWebhook';
        return $this->client->get($url);
    }
}