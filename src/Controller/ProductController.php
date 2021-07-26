<?php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

// ...
$request = Request::createFromGlobals();

class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'product_createOne',  methods: ['POST', 'HEAD'])]
    public function createOne(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();

        $product_price = (float)($request->request->get('product_price'));
        $product_amount = (int)($request->request->get('product_amount'));

        $product->setProductName($request->request->get('product_name'));
        $product->setProductPrice($product_price);
        $product->setProductDescription(($request->request->get('product_description')));
        $product->setProductSummary(($request->request->get('product_summary')));
        $product->setProductAmount($product_amount);
        $product->setProductStatus(($request->request->get('product_status')));

        $entityManager->persist($product);

        $entityManager->flush();

        return $this->redirect('/product/index', 301);
    }

    #[Route('/product/create', name: 'product_create', methods: ['GET'] )]

    public function create() {
        return $this->render('Product/create.html.twig', [

        ]);
    }

    #[Route('/product/index', name: 'product_index',  methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('Product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/detail/{id}', name: 'product_detail',  methods: ['GET', 'HEAD'])]
    public function detail(string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        return $this->render('Product/detail.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/update/{id}', name: 'product_update',  methods: ['GET', 'HEAD'])]
    public function update(string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        return $this->render('Product/update.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/update/{id}', name: 'product_updateOne',  methods: ['POST'])]
    public function updateOne(Request $request, string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = (int)$id;
        $product = $entityManager->getRepository(Product::class)->find($id);

        $product_price = (float)($request->request->get('product_price'));
        $product_amount = (int)($request->request->get('product_amount'));

        $product->setProductName($request->request->get('product_name'));
        $product->setProductPrice($product_price);
        $product->setProductDescription(($request->request->get('product_description')));
        $product->setProductSummary(($request->request->get('product_summary')));
        $product->setProductAmount($product_amount);
        $product->setProductStatus(($request->request->get('product_status')));
        $entityManager->flush();

        return $this->redirect('/product/index', 301);
    }

    #[Route('/product/delete/{id}', name: 'product_delete', methods: ['GET'])]
    public function deleteOne(int $id) : Response {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirect('/product/index', 301);
    }
}
?>
