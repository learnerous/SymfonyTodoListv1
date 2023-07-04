<?php

namespace App\Document;
use App\Repository\TodoListRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Symfony\Component\Validator\Constraints as Assert;
use App\Document\TodoList;

/**
 * @MongoDB\Document
 */
class Task
{



   /* public function getTodoList()
    {
        return $this->TodoList->getId();
    }*/


    public function setTodoList($todolist):void
    {
        $this->TodoList =$todolist;
    }

    /**
     * @return string
     */
    public function getTaskTitle(): string
    {
        return $this->TaskTitle;
    }
    /**
     * @param string $TaskTitle
     */
    public function setTaskTitle(string $TaskTitle): void
    {
        $this->TaskTitle = $TaskTitle;
    }
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTaskStatus(): string
    {
        return $this->TaskStatus;
    }

    /**
     * @param string $TaskStatus
     */
    public function setTaskStatus(string $TaskStatus): void
    {
        $this->TaskStatus = $TaskStatus;
    }

    /**
     * @ReferenceOne(targetDocument=TodoList::class)
     *     strategy="atomicSetArray",
     *     cascade={"persist"}
     */
    private $TodoList;

    /** @MongoDB\Field(type="string")
     * @Assert\NotBlank(message = "Task title is required")
     */
    private string $TaskTitle;
    /** @MongoDB\Id(type="integer",strategy="AUTO") */
    private string $id;
    /** @MongoDB\Field(type="string") */
    private string $description;
    /** @MongoDB\Field(type="string")
     ** @Assert\Choice({"todo", "in-progress", "done"}, message="Choose a valid status.")
     */
    private string $TaskStatus;

//make getter and setter to all attributes



}