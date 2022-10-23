<?php

namespace alexshent\tbot;

class TrelloClient {

    const URL = 'https://api.trello.com/1/';

    private RestClient $client;

    public function __construct() {
        $this->client = new CurlClient();
    }

    public function getBoards() {
        $key = Config::TRELLO_KEY;
        $token = Config::TRELLO_TOKEN;
        $url = self::URL . "members/me/boards?key=$key&token=$token";
        $result = $this->client->get($url);
        return $result;
    }

    public function getListsOnBoard($boardId) {
        $key = Config::TRELLO_KEY;
        $token = Config::TRELLO_TOKEN;
        $url = self::URL . "boards/$boardId/lists?key=$key&token=$token";
        $result = $this->client->get($url);
        return $result;        
    }

    public function getCardsInList(string $listId) {
        $key = Config::TRELLO_KEY;
        $token = Config::TRELLO_TOKEN;
        $url = self::URL . "lists/$listId/cards?key=$key&token=$token";
        $result = $this->client->get($url);
        return $result;
    }

    public function getMember($memberId) {
        $key = Config::TRELLO_KEY;
        $token = Config::TRELLO_TOKEN;
        $url = self::URL . "members/$memberId?key=$key&token=$token";
        $headers = [
            'Accept: application/json'
        ];
        $result = $this->client->get($url, $headers);
        return $result;
    }

    public function createList($boardId, $listName) {
        $url = self::URL . "boards/$boardId/lists";
        $data = [
            'name' => $listName,
            'key' => Config::TRELLO_KEY,
            'token' => Config::TRELLO_TOKEN
        ];
        $headers = [
            'Accept' => 'application/json'
        ];
        $result = $this->client->post($url, $data, $headers);
        return $result;
    }

    public function createWebhook($callbackURL, $idModel) {
        $url = self::URL . "webhooks";
        $data = [
            'callbackURL' => $callbackURL,
            'idModel' => $idModel,
            'key' => Config::TRELLO_KEY,
            'token' => Config::TRELLO_TOKEN
        ];
        $headers = [
            'Accept' => 'application/json'
        ];
        $result = $this->client->post($url, $data, $headers);
        return $result;
    }
}