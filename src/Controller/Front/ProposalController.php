<?php

namespace App\Controller\Front;


use App\Entity\Proposal;
use App\Repository\RessourceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


class ProposalController extends AbstractController
{

    /**
     * @Route("/proposal/offer", name="new_offer")
     */
    public function proposalOffer(Request $request, RessourceRepository $ressource, UserRepository $userRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();

        if ($content = $request->getContent()) {
            $parametersAsArray = [];
            $parametersAsArray = json_decode($content, true);
        }

        $selectRessource = $ressource->findOneBy([
            "id" => $parametersAsArray["ressource_id"]
        ]);

        $user = $userRepository->findOneBy([
            'id' => $parametersAsArray['user_id']
        ]);

        $offer = new Proposal();
        $offer->setPriority($parametersAsArray['priority']);
        $offer->setRessource($selectRessource);
        $offer->setUser($user);
        $offer->setType(0);

        dump($offer);
        $entityManager->persist($offer);
        $entityManager->flush();

        return $this->json('offer', 200);
    }

    /**
     * @Route("/proposal/need", name="new_need")
     */
    public function proposalNeed()
    {

        return $this->json('need', 200);
    }

}