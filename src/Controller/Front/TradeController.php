<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TradeController extends AbstractController
{
    /**
     * @Route("/trade", name="trade_all")
     */
    public function trade_all()
    {
        return $this->render('Trade/index.html.twig');
    }

}