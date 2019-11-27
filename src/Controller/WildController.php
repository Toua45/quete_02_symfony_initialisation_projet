<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\MaxDepth;

Class WildController extends AbstractController
{
    /**
     * @Route("wild/", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
            'programs' => $programs,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("wild/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="wild_show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        $seasons = $program->getSeasons();
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @param string $categoryName
     * @Route("/wild/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName)
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category has been sent to find a category table.');
        }
        $categoryName = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($categoryName)), "-")
        );
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(
                ['name' => $categoryName]
            );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ["category" => $category],
                ["id" => "DESC"], 3
            );
        if (!$program) {
            throw $this->createNotFoundException(
                'No category with ' . $categoryName . ' title, found in category table.'
            );
        }

        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $program
        ]);
    }


    /**
     * Getting a program with a formatted slug for title
     *
     * @Route("/wild/season/{id}", defaults={"id" = null}, name="wild_season")
     * @return Response
     */
    public function showBySeason(int $id):Response
    {

        if (!$id) {
            throw $this
                ->createNotFoundException('No season has been sent to find a season table.');
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);

        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig', [
            'episodes' => $episodes,
            'program' => $program,
            'season' => $season,
            ]);
    }
}
