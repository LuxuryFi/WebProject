<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\AnService;

class AnController extends AbstractController
{
    #[Route('/an/perry1/{slug}',
     name: 'index',
     methods: ['GET', 'HEAD'],
     defaults: ['page' => 1, 'title' => 'Hello world!'
     ])]
    public function number1(string $slug='perry',$number = 200, int $page, string $title): Response
    {
        return $this->render('lucky/number.html.twig', [
            'number' => $page,
        ]);
    }

    #[Route('/an/perry2/{slug}', name: 'perry2',  methods: ['GET', 'HEAD'])]
    public function number2(string $slug='perry2',$number = 300): Response
    {
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/an/perry3/{slug}', name: 'perry3',  methods: ['GET', 'HEAD'])]
    public function number3(string $slug='perry3',$number = 400,AnService $anService): Response
    {
        return $this->render('lucky/number.html.twig', [
            'number' => $anService->method1(),
        ]);
    }

    #[Route('/an/perry4/{slug}', name: 'perry10',  methods: ['GET', 'HEAD'])]
    public function number4(string $slug='perry10',$number = 400,AnService $anService): Response
    {
        return $this->render('lucky/number.html.twig', [
            'number' => $anService->method1(),
        ]);
    }


}
?>
