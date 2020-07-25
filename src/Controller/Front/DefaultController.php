<?php

namespace App\Controller\Front;

use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Class DefaultController
 * @package App\Controller\Front
 */
class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default_index")
     */
    public function home(RessourceRepository $ressource, AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Home/index.html.twig', [
            "error" => $error
        ]);
    }

    /**
     * @Route("/dashboard", name="index_dashboard")
     * @Security("is_granted('ROLE_USER')")
     */
    public function dashboard()
    {
        return $this->render('Dashboard/index.html.twig');
    }
}