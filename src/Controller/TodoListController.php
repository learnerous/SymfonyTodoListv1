<?php

namespace App\Controller;

use App\Document\Task;
use App\Document\TodoList;
use App\Repository\TodoListRepository;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\MongoDBException;
use http\Exception\BadMessageException;
use http\QueryString;
use MongoDB\BSON\ObjectId;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class TodoListController extends AbstractController
{
    private DocumentManager $dm;
    private TodoListRepository $rep;

    public function __construct(DocumentManager $dm,TodoListRepository $rep)
    {
        $this->dm=$dm;
        $this->rep=$rep;

    }

    /**
     * @Route("/", name="todo")
     */

    public function createTodoList(): JsonResponse
    {
        $task=new Task();
        $task->setTaskTitle("Test2");
        $task->setDescription("test2");
        $task->setTaskStatus("Done");
        $TD = new TodoList();
        $TD->setTitle('Working');
        $TD->setNote('It can be dangerous');
        $TD->setCreatedBy("Salim");
        $TD->setCreateAtdate((new \DateTime)->setDate(2023,07,01));
        $TD->setEndsBy((new \DateTime)->setDate(2023,07,04));
        $TD->setStatus("done");
        $TD->addTask($task);

        $this->dm->persist($TD);
        $this->dm->flush();

        return $this->Json('Created TodoList id ' . $TD->getId());
    }
    /**
     * @Route("/TodoLists", name="todoLists")
     */
    public function getAllTodos():JsonResponse
    {
        $todos=$this->rep->findAll();
        return $this->Json($todos);

    }
    /**
     * @Route("/TodoLists/{id}", name="toddeoLists")
     */
    public function getAlleTodos($id):JsonResponse
    {
        $todos=$this->rep->find($id);
        return $this->Json($todos);

    }
    /**
     * @Route("/RemoveTodoList/{id}", name="DeleteTodo",methods={})
     */
    public function deleteTodoList($id):JsonResponse
    {
        $todo=$this->rep->find($id);
        $this->dm->flush();
        dump($todo);
        try {
            $this->dm->remove($todo);
            $this->dm->flush();
        }catch (BadMessageException $ex){
            dump($ex);
        }


        return $this->Json($todo);
    }
    /**
     * @Route("/AddTodoList", name="AddTodo")
     */
    public function AddTodoLists(Request $request):JsonResponse
    {
        $para=json_decode($request->getContent());

        $TD = new TodoList();
        $TD->setTitle($para->title);
        $TD->setCreatedBy($para->CreatedBy);
        $TD->setCreateAtdate(new DateTime($para->CreateAtdate));
        $TD->setEndsBy(new DateTime($para->EndsBy));
        $TD->setStatus($para->status);
        $TD->setNote($para->note);
        $this->dm->persist($TD);
        $this->dm->flush();
        return $this->Json($TD);
    }
    /**
     * @Route("/TodoListTaskAdd/{id}", name="kk")
     */
    public function AddTodoListTask(Request $request, $id)
    {
        $para=json_decode($request->getContent());
        $task=new Task();
        $task->setTaskTitle($para->TaskTitle);
        $task->setDescription($para->description);
        $task->setTaskStatus("Todo");
        $todo=$this->rep->find($id);
        $todo->addTask($task);
        $task->setTodoList($todo);
        $this->dm->flush();
        return ($this->json($todo));
    }
    /**
     * @Route("/UpdateTodoList/{id}", name="kkkk")
     */
    public function UPDATEtodoLIST(Request $request, $id)
    {
        try {
            $TTD = $this->rep->find($id);
        } catch (LockException|MappingException $e) {
        }
        $TD=new TodoList();
        $paraa=json_decode($request->getContent());
        $TD->setNote($paraa->note);
        $TD->setStatus($paraa->status);
        $TD->setTitle($paraa->title);
        $TD->setEndsBy(new DateTime($paraa->EndsBy));
        $TD->setCreatedBy($paraa->CreatedBy);
        $TD->setCreateAtdate(new DateTime($paraa->EndsBy));
        $TD->setTasks($paraa->Tasks);

        $this->dm->persist($TD);
        $this->dm->flush();


        return new Response('TodoList Id:'.$id);

    }




    /**
     * @Route("/TodoListByStatus/{t}", name="AddTodolistTask")
     */
    public function TodolistsByStatus($t)
    {
        $qb = $this->dm->createQueryBuilder(TodoList::class);
        $qb->find()
            ->field('status')->equals($t)
            ->getQuery()
            ->execute()->toArray();
        return $this->Json($qb);
    }
    /**
     * @Route("/TodoListByStatusDateDesc/{t}", name="AddTo")
     */
    public function TodolistsByStatusBtStatusDateDesc($t):JsonResponse
    {
        $date=new DateTime();
        $qb = $this->dm->createQueryBuilder(TodoList::class);
        $qb->find()
            ->field('status')->equals($t)
            ->sort("CreatedAtdate","desc")
            //->limit(1)
            ->getQuery()
            ->execute()->toArray();

        return $this->Json($qb);
    }

    /**
     * @Route(path="testing" , name="test")
    */
    public function FilterUsingStartingDate()
    {
        $qb = $this->dm->createQueryBuilder(TodoList::class);
        $projectObj = $qb
            //->field('id')->equals("59f889e46803fa3713454b5d")
            ->field('CreateAtdate')->lt(new DateTime('now'))

            //->hydrate(false)
            ->getQuery()
            ->execute();
            //->getSingleResult();
        return $this->Json($projectObj);
    }
    /**
     * @Route(path="EndedOrNot" , name="teest")
    */
    public function FilterUsingEndDate()
    {
        $qb = $this->dm->createQueryBuilder(TodoList::class);
        $projectObj = $qb
            //->field('id')->equals("59f889e46803fa3713454b5d")
            ->field('EndsBy')->gt(new DateTime('now'))

            //->hydrate(false)
            ->getQuery()
            ->execute();
            //->getSingleResult();
        return $this->Json($projectObj);
    }


}
