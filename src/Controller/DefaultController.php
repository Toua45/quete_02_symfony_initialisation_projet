<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        //$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('home.html.twig', [
            'website' => 'Wild Séries',
            //'categories' => $categories,
        ]);
    }
}
