<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Media;
use App\Entity\Person;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // TYPE
        $type = new Type();
        $type->setName("série");

        $manager->persist($type);

        $type = new Type();
        $type->setName("documentaire");

        $manager->persist($type);

        $type = new Type();
        $type->setName("film");

        $manager->persist($type);
        // GENRE
        $genre = new Genre();
        $genre->setName("action");

        $manager->persist($genre);

        $genre = new Genre();
        $genre->setName("science-fiction");

        $manager->persist($genre);

        $genre = new Genre();
        $genre->setName("comique");

        $manager->persist($genre);

        $genre = new Genre();
        $genre->setName("fantastique");

        $manager->persist($genre);
        //PERSON
        $peter = new Person();
        $peter->setType("producer");
        $peter->setName("Peter Jackson");
        $peter->setImage("uploads/person/p.webp");

        $manager->persist($peter);

        $fran = new Person();
        $fran->setType("producer");
        $fran->setName("Frances Walsh");
        $fran->setImage("uploads/person/fran.webp");

        $manager->persist($fran);

        $elijah = new Person();
        $elijah->setType("actor");
        $elijah->setName("Elijah Wood");
        $elijah->setImage("uploads/person/froson.webp");

        $manager->persist($elijah);

        $sean = new Person();
        $sean->setType("actor");
        $sean->setName("Sean Astin");
        $sean->setImage("uploads/person/sam.webp");

        $manager->persist($sean);

        $gandalf = new Person();
        $gandalf->setType("actor");
        $gandalf->setName("Ian McKellen");
        $gandalf->setImage("uploads/person/gandalf.jpg");

        $manager->persist($gandalf);
        //MEDIA
        $media = new Media();
        $media->setName("Le seigneur des anneaux : La communauté de l'anneau");
        $media->setDescription("LA LEGENDE PREND VIE - Peter Jackson met en scène le début des aventures épiques de Frodon, chargé de détruire un anneau magique. Adapté des récits de Tolkien, Le Seigneur des Anneaux peint un univers fantastique sans frontières au coeur des paysages sublimes de Nouvelle-Zélande.");
        $media->setDuration(new \DateTime("2:58:00"));
        $media->setReleaseDate(new \DateTime("2001-12-19"));
        $media->setImage("uploads/media/s1.jpg");

        $media->addGenre($genre);
        $media->setType($type);

        $media->addStaff($elijah);
        $media->addStaff($gandalf);
        $media->addStaff($sean);
        $media->addStaff($peter);
        $media->addStaff($fran);

        $manager->persist($media);


        $media = new Media();
        $media->setName("Le seigneur des anneaux 2 : Les deux Tours");
        $media->setDescription("Après le premier opus qui a ravi les fans de l'univers de Tolkien (et les autres), le voyage périlleux de Frodon continue. Le mystérieux Gollum fait son entrée et prend de l'importance, les batailles font rage. Le grand spectacle fantastique et épique se poursuit pour encore plus d'effets spéciaux et de rebondissements. Le film reçoit l'oscar des meilleurs effets visuels et celui du meilleur montage sonore.");
        $media->setDuration(new \DateTime("2:58:00"));
        $media->setReleaseDate(new \DateTime("2002-12-18"));
        $media->setImage("uploads/media/s2.jpg");

        $media->addGenre($genre);
        $media->setType($type);

        $media->addStaff($elijah);
        $media->addStaff($gandalf);
        $media->addStaff($sean);
        $media->addStaff($peter);
        $media->addStaff($fran);

        $manager->persist($media);

        $media = new Media();
        $media->setName("Le seigneur des anneaux 3 : Le Retour du roi");
        $media->setDescription("Troisième et dernier opus de la saga fantastique consacrée aux aventures de Frodon, le film met fin à l'épopée de façon magistrale. Peter Jackson et son équipe respectent encore minutieusement l'oeuvre de Tolkien et travaillent avec précision sur les costumes, la mise en scène des batailles, les décors pour créer l'univers magique des livres. Véritable voyage initiatique et périlleux, Le retour du Roi nous emmène au delà du fantastique.");
        $media->setDuration(new \DateTime("3:21:00"));
        $media->setReleaseDate(new \DateTime("2003-12-17"));
        $media->setImage("uploads/media/s3.jpg");

        $media->addGenre($genre);
        $media->setType($type);

        $media->addStaff($elijah);
        $media->addStaff($gandalf);
        $media->addStaff($sean);
        $media->addStaff($peter);
        $media->addStaff($fran);

        $manager->persist($media);



        $manager->flush();


    }
}
