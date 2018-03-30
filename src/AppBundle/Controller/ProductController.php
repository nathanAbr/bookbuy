<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductForm;
use AppBundle\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\ProductTypeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function addAction(ProductService $productService, Request $request, ProductTypeService $productTypeService)
    {
        $session = $request->getSession();
        $user = $session->get('user');
        if($user !== null){
            $form = $this->createForm(ProductForm::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $product = $form->getData();
                $r = $productService->add($product);
                if ($r !== null) {
                    return new Response($r, 500);
                }

                return $this->redirect($request->getUri());
            }

            return $this->render(
                'default/create_product.html.twig',
                array(
                    'form' => $form->createView(),
                    'productType' => $productTypeService->findAll(),
                )
            );
        } else {
            return $this->redirect('/connect');
        }
    }
}
