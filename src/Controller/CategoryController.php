<?php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// ...
$request = Request::createFromGlobals();

/**
 *  @IsGranted("ROLE_USER")
 */
class CategoryController extends AbstractController
{
    #[Route('/category/create', name: 'category_create')]
    public function createOne(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success","Create category succeed !");
            return $this->redirectToRoute("category_index");
        }
        return $this->render(
            'category/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
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

    #[Route('/category/update/{id}', name: 'category_update')]
    public function update(Request $request, string $id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success","Create category succeed !");
            return $this->redirectToRoute("category_index");
        }

        return $this->render(
            'category/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
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
