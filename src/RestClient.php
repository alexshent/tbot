<?php

namespace alexshent\tbot;

interface RestClient {
    public function get(string $url, array $headers): string;
    public function post(string $url, array $data, array $headers): string;
}