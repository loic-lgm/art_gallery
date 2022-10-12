<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Entity\Image;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $artworkName = trim($form->get("name")->getData());
        $artworkNameLower = strtolower($artworkName);
        $artWorkWithoutSpace = (str_replace(' ', '-', $artworkNameLower));
        // $artWorkWithoutAccents = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')
        // ->transliterate($artWorkWithoutSpace);
        // dd(\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($artWorkWithoutSpace));
        $artwork->setSlug($artWorkWithoutSpace);

        $artwork->setCreatedAt(new \DateTimeImmutable());
        $artwork->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();

            foreach($images as $image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setName($fichier);
                $artwork->addImage($img);
            }

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
    public function edit(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository, ImageRepository $imageRepository): Response
    {
        $getAllImagesByArtwork = $imageRepository->findByArtworkId($artwork);

        $form = $this->createForm(ArtworkType::class, $artwork, ['images' => $getAllImagesByArtwork]);
        $form->handleRequest($request);

        $artworkName = trim($form->get("name")->getData());
        $artworkNameLower = strtolower($artworkName);
        $artwork->setSlug(str_replace(' ', '-', $artworkNameLower));

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();

            foreach($images as $image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setName($fichier);
                $artwork->addImage($img);
            }

            // find the image who will be used as main image
            $mainImage = $imageRepository->find($form->get("mainImage")->getData());

            // get the previous main image
            $oldMainImage = $imageRepository->findOneBy(['isMain' => true]);

            // if $mainImage is different to $oldMainImage
            if ($form->get('mainImage')->getData() !== $oldMainImage) {

                if ($oldMainImage) {
                    // set isMain to false
                    $oldMainImage->setIsMain(false);
                }
                    
                // set isMain to true
                $mainImage->setIsMain(true);
            }
            
            $artwork->setUpdatedAt(new \Datetime());
            $artworkRepository->add($artwork, true);

            return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artwork/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_admin_artwork_delete", methods={"POST"})
     */
    public function delete(Request $request, Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artwork->getId(), $request->request->get('_token'))) {
            $artworkRepository->remove($artwork, true);
        }

        return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/image/{id}", name="app_admin_artwork_delete_image", methods={"POST"})
     */
    public function deleteImage(Request $request, Image $image, ArtworkRepository $artworkRepository, ImageRepository $imageRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_tokenImage'))) {
            unlink($this->getParameter('images_directory') . '/' . $image->getName());
            $imageRepository->remove($image, true);
        }

        return $this->redirectToRoute('app_admin_artwork_index', [], Response::HTTP_SEE_OTHER);
    }
}
