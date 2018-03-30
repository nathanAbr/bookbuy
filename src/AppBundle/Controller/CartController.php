<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Service\CartService;
use AppBundle\Service\ProductService;
use AppBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function addAction($product, Request $request, ProductService $productService, CartService $cartService, UserService $userService)
    {
        $session = $request->getSession();
        $user = $session->get('user');
        if($user !== null){
            $cart = $user->getCart();
            $product = $productService->find($product);
            if($cart == null){
                $cart = new Cart();
                $cart->addProduct($product);
            } else {
                $cart->addProduct($product);
            }
            $date = new \DateTime();
            $date->modify('+14 day');
            $cart->setTerm($date);
            $user->setCart($cart);
            $cartService->add($cart);
            $userService->add($user);
            return $this->redirect('/'.$product->getProductType()->getLabel().'/products');
        }else {
            return $this->redirect('connect');
        }
    }

    public function showAction($username, CartService $cartService, UserService $userService, Request $request){
        $session = $request->getSession();
        $user = $session->get('user');
        if($user !== null){
            $user = $userService->find($username);
            $cart = $cartService->find($user);
            return $this->render('', array('cart' => $cart));
        }
        else {
            return $this->redirect('/connect');
        }
    }
}
