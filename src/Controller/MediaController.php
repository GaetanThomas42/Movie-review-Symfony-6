<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('admin/média')]
#[IsGranted("ROLE_ADMIN")]
class MediaController extends AbstractController
{
    #[Route('/', name: 'app_media_index', methods: ['GET'])]
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_media_new', methods: ['GET', 'POST'])]
    public function new(FileUploader $fileUploader,Request $request, MediaRepository $mediaRepository): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {

                $res = $fileUploader->upload($imageFile,$fileUploader->getMediaDirectory());

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $medium->setImage('uploads/media/' .$res);
            }

            $mediaRepository->save($medium, true);

            return $this->redirectToRoute('app_media_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_media_show', methods: ['GET'])]
    public function show(int $id,Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_media_edit', methods: ['GET', 'POST'])]
    public function edit(FileUploader $fileUploader,Request $request, Media $medium, MediaRepository $mediaRepository): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {

                $res = $fileUploader->upload($imageFile,$fileUploader->getMediaDirectory());

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $fileUploader->removeFile($medium->getImage());
                
                $medium->setImage("uploads/media/" . $res);
            }

            $mediaRepository->save($medium, true);

            return $this->redirectToRoute('app_media_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_media_delete', methods: ['POST'])]
    public function delete(FileUploader $fileUploader, Request $request, Media $medium, MediaRepository $mediaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            //Supprimer image
            $fileUploader->removeFile($medium->getImage());
            $mediaRepository->remove($medium, true);

        }

        return $this->redirectToRoute('app_media_index', [], Response::HTTP_SEE_OTHER);
    }
}
