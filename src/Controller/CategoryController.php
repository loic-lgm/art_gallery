<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="app_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_category_show", methods={"GET"})
     */
    public function show(Category $category, ArtworkRepository $artworkRepository): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'artworks' => $artworkRepository->findByCategory($category)
        ]);
    }
}
