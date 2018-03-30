<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:37
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function add($user){
        try{
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (DBALException $e){

        }
    }

    public function find($username){
        return $this->repository->findOneBy(array('username'=>$username));
    }
}