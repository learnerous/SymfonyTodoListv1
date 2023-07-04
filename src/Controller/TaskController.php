<?php

namespace App\Controller;

use App\Document\Task;
use App\Document\TodoList;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private DocumentManager $dm;
    public function __construct(DocumentManager $dm)
    {
        $this->dm=$dm;
    }

    /**
     * @Route("/Task", name="task")
     */

    public function createTodoList(): JsonResponse
    {
        $TD = new Task();
        $TD->setDescription("sleep");
        $TD->setTaskStatus("todo");
        $TD->setTaskTitle("ba33");
        $TD->setTodoList(64);
        $this->dm->persist($TD);
        $this->dm->flush();
        return $this->Json('Created Task id ' . $TD->getId());
    }
    /**
     * @Route ("/Tasks",name="tasks")
     */
    public function FindAllUser(TaskRepository $rep):JsonResponse
    {
        $tasks=$rep->findAll();
        return $this->Json($tasks);
    }
    /**
     * @Route ("/addTasktoTodo",name="tasksAdd")
     */
    public function AddTasksToTodoList(Request $request): JsonResponse
    {
        $para=json_decode($request->getContent());
        $task=new Task();
        $task->setTaskTitle($para->TaskTitle);
        $task->setDescription($para->description);
        $task->setTaskStatus("Todo");
        $this->dm->persist($task);
        $this->dm->flush();
        return $this->Json("task added".$task->getId());
    }

    /**
     * @Route("/select/{t}",name="select")
     */
    public function GetTaskbyStatus($t)
    {
        $qb = $this->dm->createQueryBuilder(Task::class);

        $qb->find()
            ->field('TaskStatus')->equals($t)
            ->getQuery()
            ->execute()->toArray();
        return $this->Json($qb);
    }


}
