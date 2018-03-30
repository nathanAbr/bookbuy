<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:38
 */

namespace AppBundle\Service;


use AppBundle\Entity\Cart;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Cart::class);
    }

    public function add($cart){
        try{
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        } catch (DBALException $e){
            return $e->getMessage();
        }
    }

    public function find($user){
        return $this->repository->findOneBy(array('user'=>$user));
    }
}