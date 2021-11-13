<?php

namespace App\Controller;

use DateTime;
use App\Entity\Task;
use App\Message\DeleteMessage;
use App\Message\PostMessage;
use App\Message\PatchMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/rabbit/tasks")
 */
class TaskController extends AbstractController
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function addTask(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->bus->dispatch(new PostMessage($data));

       // return $this->redirectToRoute('tasks_list');
       return new JsonResponse(['message' => 'New task has been added']);
    }

    /**
     * @Route("/{taskId}", methods={"PATCH"})
     */
    public function updateTask(int $taskId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->bus->dispatch(new PatchMessage($taskId, $data));

        $list = $this->em->getRepository(Task::class)->findBy([], ['date' => 'ASC']);

        return new JsonResponse(['message' => 'Task has been updated']);
    }

    /**
     * @Route("/{taskId}", methods={"DELETE"})
     */
    public function deleteTask(int $taskId): JsonResponse
    {
        $this->bus->dispatch(new DeleteMessage($taskId));

        return new JsonResponse(['message' => 'Task has been deleted']);
    }
}
