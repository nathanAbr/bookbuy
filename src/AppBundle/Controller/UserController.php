<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserForm;
use AppBundle\ProductTypes;
use AppBundle\Service\ProductTypeService;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    public function addAction(UserService $userService, Request $request, ProductTypeService $productTypeService)
    {
        $form = $this->createForm(UserForm::class);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $user = $form->getData();
            $userService->add($user);
            return $this->redirect($request->getUri());
        }

        return $this->render('default/create_user.html.twig', array('form' => $form->createView(),
            'productType'=>$productTypeService->findAll(),));
    }

    public function connectAction(Request $request, ProductTypeService $productTypeService, UserService $userService){
        $form = $this->createForm(UserForm::class);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $user = $userService->find($form->get('username')->getData());
            if($user !== null){
                $session = new Session();
                $session->start();
                $session->set('user', $user);
                $request->setSession('user', $session);
                return $this->redirect('/');
            }
        }

        return $this->render('default/create_user.html.twig', array('form' => $form->createView(),
            'productType'=>$productTypeService->findAll(),));
    }
}
