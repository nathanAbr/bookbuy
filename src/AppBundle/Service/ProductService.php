<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:38
 */

namespace AppBundle\Service;


class ProductService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function add($product){
        try{
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (DBALException $e){

        }
    }

    public function find($label){
        return $this->repository->findOneBy(array('username'=>$label));
    }
}