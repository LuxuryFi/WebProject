<?php

namespace App\Controller;

use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserProduct;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomepageController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    #[Route('/homepage', name: 'homepage')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('homepage/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/homepage/wishlist', name: 'getWishlist')]
    public function wishlist(AuthenticationUtils $authenticationUtils): Response
    {
        $username = $authenticationUtils->getLastUsername();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy([
        'username' => $username]);

        $products = $entityManager->getRepository(UserProduct::class)->findBy([
            'user' => $user,
        ]);
        return $this->render('homepage/wishlist.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/homepage/cart', name: 'cart')]
    public function cart(AuthenticationUtils $authenticationUtils): Response
    {
        $username = $authenticationUtils->getLastUsername();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy([
        'username' => $username]);

        $products = $entityManager->getRepository(Cart::class)->findBy([
            'user' => $user->getId(),
        ]);
        return $this->render('homepage/cart.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/homepage/cart/add', name: 'cart_add', methods:['POST'])]
    public function addCart(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cart = new Cart();

        $product_id = $request->request->get('product_id');
        $user_id = $request->request->get('user_id');
        $price = $request->request->get('price');
        $amount = 1;

        $user = $entityManager->getRepository(User::class)->find($user_id);
        $product = $entityManager->getRepository(Product::class)->find($product_id);

        $cart->setUserId($user);
        $cart->setProduct($product);
        $cart->setPrice($price);
        $cart->setAmount($amount);

        $entityManager->persist($cart);

        $entityManager->flush();

        return new Response(
            Response::HTTP_OK,
        );
    }

    #[Route('/homepage/order', name: 'addOrder')]
    public function addOrder(AuthenticationUtils $authenticationUtils): Response
    {
        $username = $authenticationUtils->getLastUsername();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy([
        'username' => $username]);

        $products = $entityManager->getRepository(Order::class)->findBy([
            'user' => $user->getId(),
        ]);
        return $this->render('homepage/order.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/homepage/order', name: 'getOrder')]
    public function getOrder(AuthenticationUtils $authenticationUtils): Response
    {
        $username = $authenticationUtils->getLastUsername();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy([
        'username' => $username]);

        $products = $entityManager->getRepository(Order::class)->findBy([
            'user' => $user->getId(),
        ]);
        return $this->render('homepage/order.html.twig', [
            'products' => $products,
        ]);
    }
}
