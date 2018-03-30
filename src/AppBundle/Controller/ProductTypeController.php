<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductTypeForm;
use AppBundle\Service\ProductTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ProductTypeController extends Controller
{
    public function addAction(Request $request, ProductTypeService $productTypeService)
    {
        $form = $this->createForm(ProductTypeForm::class)->add('save', SubmitType::class);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $productType = $form->getData();
            $productTypeService->add($productType);
            return $this->redirect($request->getUri());
        }

        return $this->render('default/create_product_type.html.twig', array('form' => $form->createView(),
            'productType'=>$productTypeService->findAll(),
            ));
    }

    public function showAction($productType, ProductTypeService $productTypeService, Request $request){
        $session = $request->getSession();
        $user = $session->get('user');
        if($user !== null){
            $products = $productTypeService->find($productType);
            return $this->render(
                'default/show_product.html.twig',
                array(
                    'product' => $products,
                    'productType' => $productTypeService->findAll(),
                )
            );
        } else {
            return $this->redirect('/connect');
        }
    }
}
