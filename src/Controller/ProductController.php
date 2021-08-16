<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// ...

/**
 *  @IsGranted("ROLE_ADMIN")
 */
class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request) {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $product->getAvatar();

            $fileName = md5(uniqid());
            $fileExtension = $avatar->getExtension();

            echo $avatar;
            $imageName = $fileName . '.' . $fileExtension;

            try {
                $avatar->move(
                    $this->getParameter('product_image'), $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }

            //set imageName to database
            $product->setAvatar($imageName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash("Success","Create product succeed !");
            return $this->redirectToRoute("product_index");
        }

        return $this->render(
            'product/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
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

    #[Route('/product/update/{id}', name: 'product_updateOne')]
    public function updateOne(Request $request, string $id): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash("Success","Create product succeed !");
            return $this->redirectToRoute("product_index");
        }

        return $this->render(
            'product/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
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
