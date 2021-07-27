<?php
namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

// ...
$request = Request::createFromGlobals();

class CategoryController extends AbstractController
{
    #[Route('/category/create', name: 'category_createOne',  methods: ['POST', 'HEAD'])]
    public function createOne(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $category->setCategoryName($request->request->get('category_name'));
        $category->setCategoryDescription(($request->request->get('category_description')));

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirect('/category/index', 301);
    }

    #[Route('/category/create', name: 'category_create', methods: ['GET'] )]
    public function create() {
        return $this->render('category/create.html.twig', []);
    }

    #[Route('/category/index', name: 'category_index',  methods: ['GET', 'HEAD'])]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/detail/{id}', name: 'category_detail',  methods: ['GET', 'HEAD'])]
    public function detail(string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(category::class)->find($id);
        return $this->render('category/detail.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/category/update/{id}', name: 'category_update',  methods: ['GET', 'HEAD'])]
    public function update(string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(category::class)->find($id);
        return $this->render('category/update.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/category/update/{id}', name: 'category_updateOne',  methods: ['POST'])]
    public function updateOne(Request $request, string $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = (int)$id;
        $category = $entityManager->getRepository(category::class)->find($id);

        $category->setCategoryName($request->request->get('category_name'));
        $category->setCategoryDescription(($request->request->get('category_description')));
        $entityManager->flush();

        return $this->redirect('/category/index', 301);
    }

    #[Route('/category/delete/{id}', name: 'category_delete', methods: ['GET'])]
    public function deleteOne(int $id) : Response {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(category::class)->find($id);
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirect('/category/index', 301);
    }
}
?>
