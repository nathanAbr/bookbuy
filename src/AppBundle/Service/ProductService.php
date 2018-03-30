<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 30/03/2018
 * Time: 10:38
 */

namespace AppBundle\Service;


use AppBundle\Entity\Product;
use AppBundle\Repository\ProductRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $entityManager;
    private $repository;
    private $productTypeService;

    public function __construct(EntityManagerInterface $entityManager, ProductTypeService $productTypeService)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Product::class);
        $this->productTypeService = $productTypeService;
    }

    public function add($product){
        try{
            $productType = $this->productTypeService->find($product->getProductType()->getLabel());
            if($productType === null){
                $this->productTypeService->add($productType);
            }
            $product->setProductType($productType);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (DBALException $e){
            return $e->getMessage();
        }
    }

    public function find($label){
        return $this->repository->findOneBy(array('label'=>$label));
    }
}