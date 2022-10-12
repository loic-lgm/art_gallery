<?php

namespace App\Controller;

use App\Entity\Artwork;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artwork")
 */
class ArtworkController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_artwork_show", methods={"GET"})
     */
    public function show(Artwork $artwork): Response
    {
        return $this->render('artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }
}
