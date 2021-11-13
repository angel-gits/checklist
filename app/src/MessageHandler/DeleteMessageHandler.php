<?php 

namespace App\MessageHandler;

use App\Entity\Task;
use App\Message\DeleteMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteMessageHandler implements MessageHandlerInterface {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function __invoke(DeleteMessage $message) {
        $id = $message->getId();

        $task = $this->em->getRepository(Task::class)->findOneBy(['id' => $id]);

        if(!is_null($task)) {
            $this->em->remove($task);
            $this->em->flush();
        }
    }
}