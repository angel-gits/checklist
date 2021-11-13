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
            if(!is_null($name = $data['name' ?? null])) {
                $task->setName($name); 
            }
            if(!is_null($description = $data['description'] ?? null)) {
                $task->setDescription($description);
            }
            if(!is_null($date = $data['date'] ?? null)) {
                $task->setDate(new DateTime($date)); 
            }
            if(!is_null($status = $data['status'] ?? null)) {
                $task->setStatus((int)$status);
            }
            if(!is_null($done = $data['done'] ?? null)) {
                $task->setDone($done);
            }

            $this->em->flush();
        }
    }
}