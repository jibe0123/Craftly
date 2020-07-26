<?php

namespace App\Controller\Front;

use App\Entity\Ressource;
use App\Repository\CategoryRepository;
use App\Repository\ProposalRepository;
use App\Repository\RessourceRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;


class RessourceController extends AbstractController
{
    /**
     * @Route("/ressources", name="ressources_all")
     */
    public function ressources_all(RessourceRepository $ressource, ProposalRepository $proposalRepository)
    {
        $proposal_offer = $proposalRepository->findBy([
            'type' => 1
        ]);

        $proposal_need = $proposalRepository->findBy([
            'type' => 0
        ]);

        return $this->render('Ressource/index.html.twig', [
            'ressources' => $ressource->findAll(),
            'offer' => $proposal_offer,
            'need' => $proposal_need,
        ]);
    }

    /**
     * @Route("/ressource/{uuid}", name="ressource_view")
     */
    public function ressource_view(RessourceRepository $ressource, $uuid)
    {
        return $this->render('Ressource/view.html.twig', [
            "ressource" => $ressource->findOneBy([
                'uuid' => $uuid,
            ])
        ]);
    }

    /**
     * @Route("/add-ressource", name="add_ressource")
     */
    public function add(Request $request,RessourceRepository $ressource, CategoryRepository $category)
    {
        $selectCateg = $request->query->get('selectCateg');
        $lvl_default = 0;

        $selectEntity = $category->findOneByTitle($selectCateg);

        $children = $category->children($selectEntity, true);

        $path = $category->getPath($selectEntity);

        return $this->render('Ressource/ressource.html.twig', [
            "category" => $children,
            "selectCateg" => $path
        ]);
    }

    /**
     * @Route("/new-ressource", name="new_ressource", methods={"POST"})
     */
    public function new(Request $request,RessourceRepository $ressource, CategoryRepository $category)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = [];
            $parametersAsArray = json_decode($content, true);
        }
        $uuid = Uuid::uuid4();
        $entityManager = $this->getDoctrine()->getManager();
        $category = $category->findOneByTitle($parametersAsArray["category"]);

        dump($parametersAsArray);
        $ressource = new Ressource();
        $ressource->setName($parametersAsArray["name"]);
        $ressource->setDescription($parametersAsArray["description"]);
        $ressource->setUuid($uuid);
        $ressource->setCategory($category);
        $entityManager->persist($ressource);
        $entityManager->flush();

        return new JsonResponse($uuid, 200);
    }

    /**
     * @Route("/ressource/search/{name}", name="search_name_ressource")
     */
    public function search_ressource_name(RessourceRepository $ressource, SerializerInterface $serializer, $name)
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = "SELECT name, uuid FROM ressource
                WHERE ressource.name LIKE CONCAT('%', :name , '%')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name]);
        $r = $stmt->fetchAll();


        return $this->json($r, 200);
    }

    /**
     * @Route("/ressource/{id}/attributes", name="ressource_attributex")
     */
    public function ressource_attributes($id, RessourceRepository $ressource)
    {
        $res = $ressource->findOneBy([
            'id' => $id
        ]);

        $attributes = $res->getCategory()->getAttributes();

        $result = [];
        foreach ($attributes as $a){
            array_push($result, [
                "id" => $a->getId(),
                "name" => $a->getName(),
                "unit" => $a->getUnit()
            ]);
        }

        return $this->json($result, 200);
    }



}