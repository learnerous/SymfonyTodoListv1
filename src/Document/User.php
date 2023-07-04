<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\Document
 */
class User
{

    /**
     * @ReferenceMany(targetDocument=TodoList::class)
     */
    private $TodoLists = [];
    /** @MongoDB\Field(type="string")
     * @Assert\NotBlank(message = "title is required")
     */
    private string $Name;
    /** @MongoDB\Id(type="integer",strategy="AUTO") */
    private string $id;
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message = "Password  is required ")
     */
    private string $Password;

//make getter and setter to all attributes
    public function __construct()
    {

    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
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
    public function getPassword(): string
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    /**
     * @return array
     */
    public function getTodoLists(): array
    {
        return array($this->TodoLists);
    }

    /**
     * @param array $TodoLists
     */
    public function setTodoLists(array $TodoLists): void
    {
        $this->TodoLists = $TodoLists;
    }
}