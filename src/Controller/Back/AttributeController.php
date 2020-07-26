<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AttributeRepository;
use App\Entity\Attribute;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AttributeController
 * @package App\Controller\Back
 */
class AttributeController extends AbstractController
{
    /**
     * @Route("/attribute/list", name="list_attributes", methods={"GET"})
     */
    public function list(AttributeRepository $attribute): Response
    {
        $attribute = $attribute->findAll();


        return $this->render('back/attribute/attribute.list.html.twig', [
            'attr' => $attribute,
        ]);
        
    }
    /**
     * @Route("/attribute/new", name="back_new_attribute", methods={"GET","POST"})
     */
    public function new(AttributeRepository $attribute , Request $request): Response
    {

        if ($request->isMethod('post')) { 

            $name = $request->request->get('attribute_name');
            $unit = $request->request->get('attribute_unit');
            $entityManager = $this->getDoctrine()->getManager();
            $attribute = new Attribute();
            $attribute->setName($name);
            $attribute->setUnit($unit);
            $entityManager->persist($attribute);
            $entityManager->flush();
            return new Response('ok');
        }

        return $this->render('back/attribute/attribute.new.html.twig', [
        ]);
        
    }
}