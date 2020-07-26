<?php

namespace App\Controller\Back;

use App\Entity\ProposalAttribute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\AttributeRepository;
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
    public function list(CategoryRepository $categoryRepository, Request $request): Response
    {
        $selectCateg = $request->query->get('categ');

        $selectEntity = $categoryRepository->findOneByTitle($selectCateg);

        $children = $categoryRepository->children($selectEntity, true);

        $path = $categoryRepository->getPath($selectEntity);

        dump($path);
        dump($children);

        return $this->render('back/category/category.list.html.twig', [
            "childs" => $children,
            "pathCateg" => $path,
            "selecCateg" => $selectCateg,
        ]);
        
    }

    /**
     * @Route("/category/show/{title}", name="show_category", methods={"GET", "POST"})
     */
    public function show(CategoryRepository $category, $title, AttributeRepository $attribute, Request $request): Response
    {
        $category = $category->findOneByTitle($title);
        $attr = $attribute->findAll();

        $categoryAttribute = $category->getAttributes();
        dump($categoryAttribute);


        if ($request->isMethod('post')) { 
            $new_attributes = $request->request->get('newAttribute');
            $entityManager = $this->getDoctrine()->getManager();

            $attributeToAdd = $attribute->findOneBy([
                'name' => $new_attributes
            ]);

            $category->addAttribute($attributeToAdd);


            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('show_category', [
                'title' => $title
            ]);
        }


        return $this->render('back/category/category.show.html.twig', [
            'categ' => $category,
            'categAttr' => $categoryAttribute,
            'attribute' => $attr
        ]);
        
    }

    /**
     * @Route("/category/new", name="new_category", methods={"GET","POST"})
     */
    public function new(CategoryRepository $category , Request $request): Response
    {

        $categ = $request->query->get('category');
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