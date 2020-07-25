<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package App\Controller\Back
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/category/list", name="list_categories", methods={"GET"})
     */
    public function list(CategoryRepository $category): Response
    {
        $category = $category->findAll();

        if (!$category) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        dump($category);

        return $this->render('back/category/category.list.html.twig', [
            'categ' => $category,
        ]);
        
    }
    /**
     * @Route("/category/new", name="new_category", methods={"GET","POST"})
     */
    public function new(CategoryRepository $category , Request $request): Response
    {
        // if meth requete = post alors + categ ifels poubelle

        $categ = $request->query->get('categ');
        $selectedCategory = $category->findOneByTitle($categ);


        if ($request->isMethod('post')) { 
            dump($selectedCategory);

            $name = $request->request->get('category_name');
            $entityManager = $this->getDoctrine()->getManager();
            $category = new Category();
            $category->setTitle($name);
            $category->setParent($selectedCategory);
            $entityManager->persist($category);
            $entityManager->flush();
            return new Response('ok');
        }


        return $this->render('back/category/category.new.html.twig', [
        ]);
        
    }
}