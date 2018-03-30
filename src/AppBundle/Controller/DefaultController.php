<?php

namespace AppBundle\Controller;

use AppBundle\Service\ProductTypeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    private $productTypes;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(ProductTypeService $productTypeService)
    {
        $this->productTypes = $productTypeService->findAll();
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'productType' => $this->productTypes,
        ]);
    }
}
