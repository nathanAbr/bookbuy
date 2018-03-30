<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:37
 */

namespace AppBundle\Service;

use AppBundle\Repository\UserRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
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