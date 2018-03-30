<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:38
 */

namespace AppBundle\Service;


class CartService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function add($cart){
        try{
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        } catch (DBALException $e){

        }
    }

    public function find($user){
        return $this->repository->findOneBy(array('user'=>$user));
    }
}