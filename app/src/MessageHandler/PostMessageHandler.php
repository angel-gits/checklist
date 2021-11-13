<?php

namespace App\MessageHandler;

use DateTime;
use App\Entity\Task;
use App\Message\PostMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PostMessageHandler implements MessageHandlerInterface {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function __invoke(PostMessage $message) {
        $data = $message->getData();
        
        $dateStr = $data['date'];
        $task = new Task($data['name'], new DateTime($dateStr) , (int) $data['status'], $data['description'] ?? null);

        $this->em->persist($task);
        $this->em->flush();
    }

}