<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class MatchController extends AbstractController
{
    /**
     * @Route("/matchs", name="matchs")
     */
    public function match_all()
    {
        return $this->render('Matchs/index.html.twig');
    }

}