<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\MediaReview;
use App\Entity\Person;
use App\Repository\MediaRepository;
use App\Repository\MediaReviewRepository;
use App\Repository\PersonRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MediaRepository $mediaRepository,PersonRepository $personRepository): Response
    {
        //Récupération des derniers Media et derniers Person
        $medias = $mediaRepository->findBy([],['id'=>'DESC'],5);
        $staffs = $personRepository->findBy([],['id'=>'DESC'],5);

        return $this->render('home/index.html.twig', [
            'medias' => $medias,
            'staffs' => $staffs
        ]);
    }

    #[Route('/médias', name: 'app_home_all_medias')]
    public function allMedias(MediaRepository $mediaRepository): Response
    {
        return $this->render('home/all_medias.html.twig', [
            'medias' => $mediaRepository->findAll()

        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/média/show/{id}', name: 'app_home_show_medias')]
    public function showMedia(Media $media,MediaReviewRepository $mediaReviewRepository): Response
    {

        $average = $mediaReviewRepository->getAverageMediaRating($media->getId());

        return $this->render('home/media_show.html.twig', [
            'media' => $media,
            'average' => $average,
        ]);
    }

    #[Route('/staff', name: 'app_home_all_staff')]
    public function allStaff(PersonRepository $personRepository): Response
    {
        return $this->render('home/all_staff.html.twig', [
            'staffs' => $personRepository->findAll(),
        ]);
    }

    #[Route('/casting/show/{id}', name: 'app_home_show_person')]
    public function showPreson(Person $person): Response
    {
        return $this->render('home/staff_show.html.twig', [
            'person' => $person
        ]);
    }

}
