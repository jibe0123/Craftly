<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RessourceRepository;
use App\Entity\Ressource;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;


/**
 * Class RessourceController
 * @package App\Controller\Back
 */
class RessourceController extends AbstractController
{
    /**
     * @Route("/ressource/list", name="list_ressources", methods={"GET"})
     */
    public function list(RessourceRepository $ressource): Response
    {
        $ressource = $ressource->findAll();

        if (!$ressource) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        dump($ressource);

        return $this->render('back/ressource/ressource.list.html.twig', [
            'ress' => $ressource,
        ]);
        
    }
}