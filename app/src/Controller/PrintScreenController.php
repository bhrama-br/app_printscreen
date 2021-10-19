<?php

namespace App\Controller;

use App\Entity\PrintScreen;
use App\Form\PrintScreenType;
use App\Repository\PrintScreenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class PrintScreenController extends AbstractController
{
    /**
     * @Route("/", name="print_screen_index", methods={"GET"})
     */
    public function index(PrintScreenRepository $printScreenRepository): Response
    {
        return $this->render('print_screen/index.html.twig', [
            'print_screens' => $printScreenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="print_screen_show", methods={"GET"})
     */
    public function show(PrintScreen $printScreen): Response
    {
        return $this->render('print_screen/show.html.twig', [
            'print_screen' => $printScreen,
        ]);
    }

}
