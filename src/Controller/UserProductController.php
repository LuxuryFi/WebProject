<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProductController extends AbstractController
{
    #[Route('/user-product', name: 'user_product')]
    public function index(): Response
    {
        return $this->render('user_product/index.html.twig', [
            'controller_name' => 'UserProductController',
        ]);
    }

    #[Route('/user-product/add', name: 'user_product_like', methods:['POST'])]
    public function add(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user_product = new UserProduct();

        $product_id = $request->request->get('product_id');
        $user_id = $request->request->get('user_id');

        $user = $entityManager->getRepository(User::class)->find($user_id);
        $product = $entityManager->getRepository(Product::class)->find($product_id);

        $user_product->setUserId($user);
        $user_product->setProduct($product);

        $entityManager->persist($user_product);

        $entityManager->flush();

        return new Response(
            $product_id,
        );
    }
}
