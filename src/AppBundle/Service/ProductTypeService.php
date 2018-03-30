<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:37
 */

namespace AppBundle\Service;


use AppBundle\Entity\ProductType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class ProductTypeService
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ProductType::class);
    }

    public function add($productType){
        try{
            if($this->count()){
                $this->entityManager->persist($productType);
                $this->entityManager->flush();
            } else {
                throw new DBALException("There is 3 product type saved in database.");
            }
        } catch (DBALException $e){
            return $e;
        }
    }

    public function find($label){
        return $this->repository->findOneBy(array('label'=>$label));
    }

    public function findAll(){
        return $this->repository->findAll();
    }

    private function count(){
        if(count($this->repository->findAll()) < 3){
            return true;
        }
        return false;
    }
}