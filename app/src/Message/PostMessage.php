<?php

namespace App\Message;

class PostMessage {
    private $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function getData(): array {
        return $this->data;
    }
}