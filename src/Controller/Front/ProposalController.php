<?php

namespace App\Controller\Front;


use App\Entity\Proposal;
use App\Entity\ProposalAttribute;
use App\Repository\AttributeRepository;
use App\Repository\RessourceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProposalController extends AbstractController
{

    /**
     * @Route("/proposal/offer", name="new_offer")
     */
    public function proposalOffer(Request $request, RessourceRepository $ressource, UserRepository $userRepository, AttributeRepository  $attributeRepository)
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

        foreach ($parametersAsArray['attributes'] as $attr){
            $attributeEntity = $attributeRepository->findOneBy([
                'id' => $attr['id']
            ]);
            $proposalAttr = new ProposalAttribute();
            $proposalAttr->setAttribute($attributeEntity);
            $proposalAttr->setValue($attr['value']);
            $proposalAttr->setProposal($offer);
            $entityManager->persist($proposalAttr);
            $entityManager->persist($offer);
            $entityManager->flush();

        }
        return $this->json('Success', 200);
    }

    /**
     * @Route("/proposal/need", name="new_need")
     */
    public function proposalNeed(Request $request, RessourceRepository $ressource, UserRepository $userRepository, AttributeRepository  $attributeRepository)
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

        foreach ($parametersAsArray['attributes'] as $attr){
            $attributeEntity = $attributeRepository->findOneBy([
                'id' => $attr['id']
            ]);
            $proposalAttr = new ProposalAttribute();
            $proposalAttr->setAttribute($attributeEntity);
            $proposalAttr->setValue($attr['value']);
            $proposalAttr->setProposal($offer);
            $entityManager->persist($proposalAttr);
            $entityManager->persist($offer);
            $entityManager->flush();

        }
        return $this->json('Success', 200);
    }

}