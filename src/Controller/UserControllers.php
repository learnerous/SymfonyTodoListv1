<?php

namespace App\Controller;

use App\Document\User;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class UserControllers extends AbstractController
{
    private DocumentManager $dm;
    public UserRepository $rep;
    public function __construct(DocumentManager $dm,UserRepository $rep)
    {
        $this->dm=$dm;
        $this->rep=$rep;
    }
    /**
     * @Route("/User", name="user")
     */
    public function createUser(): JsonResponse
    {

        $TD = new User();
        $TD->setName("Oussama");
        $TD->setPassword("Oussama");
        $this->dm->persist($TD);
        $this->dm->flush();

        return $this->Json('Created product id ' . $TD->getName());
    }
    /**
     * @Route ("/users",name="user")
     */
    public function FindAllUser(UserRepository $rep)
    {
        $users=$rep->findAll();
        return $this->Json($users);


    }
    /**
     * @Route ("/users/{id}",name="userById")
     */
    public function FindAllUserByis(UserRepository $rep,$id):JsonResponse
    {
        try {
            $user = $rep->find($id);
        } catch (LockException|MappingException $e) {
        }
        return $this->Json($user);
    }
    /**
     * @Route ("/userAdd",name="addAUser")
     */
    public function Adduser(Request $request):JsonResponse
    {
        $para=json_decode($request->getContent());
        $Td=new User();
        $Td->setName($para->Name);
        $Td->setPassword($para->Password);
        //$Td->setTodoLists($para->TodoLists);
        $this->dm->persist($Td);
        $this->dm->flush();
        return $this->Json($Td);
    }


}