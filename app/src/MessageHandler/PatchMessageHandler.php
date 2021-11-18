<?php

namespace App\MessageHandler;

use DateTime;
use App\Entity\Task;
use App\Message\PatchMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PatchMessageHandler implements MessageHandlerInterface {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function __invoke(PatchMessage $message) {
        $id = $message->getId();
        $task = $this->em->getRepository(Task::class)->findOneBy(['id' => $id]);

        if(!is_null($task)) {
            $data = $message->getData();
            if(isset($data['name'])) {
                $task->setName($data['name']); 
            }
            if(isset($data['description'])) {
                $task->setDescription($data['description']);
            }
            if(isset($data['date'])) {
                $task->setDate(new DateTime($data['date'])); 
            }
            if(isset($data['status'])) {
                $task->setStatus((int)$data['status']);
            }
            if(isset($data['done'])) {
                $task->setDone($data['done']);
            }
            $this->em->flush();
        }
    }
}