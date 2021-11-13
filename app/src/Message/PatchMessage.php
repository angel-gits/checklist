<?php

namespace App\Message;

class PatchMessage {
    private $id;
    private $data;

    public function __construct(int $id, array $data) {
        $this->id = $id;
        $this->data = $data;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getData(): array {
        return $this->data;
    }
}