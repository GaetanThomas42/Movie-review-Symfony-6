<?php

namespace App\Controller;

use App\Entity\MediaReview;
use App\Form\MediaReviewType;
use App\Repository\MediaReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/media-review')]
class MediaReviewController extends AbstractController
{
    #[Route('/', name: 'app_media_review_index', methods: ['GET'])]
    public function index(MediaReviewRepository $mediaReviewRepository): Response
    {
        return $this->render('media_review/index.html.twig', [
            'media_reviews' => $mediaReviewRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_media_review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mediaReview = new MediaReview();
        $form = $this->createForm(MediaReviewType::class, $mediaReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mediaReview);
            $entityManager->flush();

            return $this->redirectToRoute('app_media_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('media_review/new.html.twig', [
            'media_review' => $mediaReview,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_media_review_show', methods: ['GET'])]
    public function show(MediaReview $mediaReview): Response
    {
        return $this->render('media_review/show.html.twig', [
            'media_review' => $mediaReview,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_media_review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MediaReview $mediaReview, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MediaReviewType::class, $mediaReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_media_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('media_review/edit.html.twig', [
            'media_review' => $mediaReview,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_media_review_delete', methods: ['POST'])]
    public function delete(Request $request, MediaReview $mediaReview, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mediaReview->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mediaReview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_media_review_index', [], Response::HTTP_SEE_OTHER);
    }
}
