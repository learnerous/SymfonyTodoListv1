<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\Document
 */
class TodoList
{

    /**
     * @ReferenceOne(targetDocument=User::class)
     *
     */
    private $User;
    /**
     * @ReferenceMany(targetDocument=Task::class,
     *     cascade={"persist"}
     *     )
     */
    private $Tasks = [];
    /** @MongoDB\Field(type="string")
     * @Assert\NotBlank(message = "title is required")
     */
    private string $title;
    /** @MongoDB\Id(type="integer",strategy="AUTO") */
    private  string $id;
    /** @MongoDB\Field(type="string") */
    private string $note;
    /** @MongoDB\Field(type="string")
     ** @Assert\Choice({"todo", "in-progress", "done"}, message="Choose a valid status.")
     */
    private string $status;
    /** @MongoDB\Field(type="date") */
//Date Of Creation
    private \DateTime $CreateAtdate;
    /** @MongoDB\Field(type="date") */
    //deadline
    private \DateTime $EndsBy;
    /** @MongoDB\Field(type="string") */
    private $CreatedBy;
//make getter and setter to all attributes
    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getNote(): string
    {
        return $this->note;
    }
    public function setNote(string $note): void
    {
        $this->note = $note;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->CreatedBy;
    }

    /**
     * @param mixed $CreatedBy
     */
    public function setCreatedBy($CreatedBy): void
    {
        $this->CreatedBy = $CreatedBy;
    }

    /**
     * @return \DateTime
     */
    public function getEndsBy(): \DateTime
    {
        return $this->EndsBy;
    }

    /**
     * @param \DateTime $EndsBy
     */
    public function setEndsBy(\DateTime $EndsBy): void
    {
        $this->EndsBy = $EndsBy;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAtdate(): \DateTime
    {
        return $this->CreateAtdate;
    }

    /**
     * @param \DateTime $CreateAtdate
     */
    public function setCreateAtdate(\DateTime $CreateAtdate): void
    {
        $this->CreateAtdate = $CreateAtdate;
    }

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return [$this->Tasks];
    }

    /**
     * @param array $Tasks
     */
    public function setTasks(array $Tasks): void
    {
        $this->Tasks = $Tasks;
    }
    public function addTask($task)
    {
        $this->Tasks[] = $task;
    }
}