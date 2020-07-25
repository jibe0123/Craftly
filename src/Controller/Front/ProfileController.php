<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile_index")
     */
    public function index()
    {
        return $this->render('Profile/index.html.twig');
    }

}