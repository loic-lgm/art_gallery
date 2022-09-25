<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/artwork")
 */
class ArtworkController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_artwork_index", methods={"GET"})
     */
    public function index(ArtworkRepository $artworkRepository): Response
    {
        return $this->render('admin/artwork/index.html.twig', [
            'artworks' => $artworkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_artwork_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArtworkRepository $artworkRepository): Response
    {
        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artworkRepository->add($artwork, true);

            return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artwork/new.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_artwork_show", methods={"GET"})
     */
    public function show(Artwork $artwork): Response
    {
        return $this->render('admin/artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_artwork_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artworkRepository->add($artwork, true);

            return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artwork/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_artwork_delete", methods={"POST"})
     */
    public function delete(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artwork->getId(), $request->request->get('_token'))) {
            $artworkRepository->remove($artwork, true);
        }

        return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
    }
}
