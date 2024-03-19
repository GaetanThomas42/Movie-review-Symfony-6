<?php

namespace App\Repository;

use App\Entity\MediaReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaReview>
 *
 * @method MediaReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaReview[]    findAll()
 * @method MediaReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaReview::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAverageMediaRating(?int $mediaId):float|null
    {
        $res = $this->createQueryBuilder('media_review')
                ->select('AVG(media_review.value) as avgRating')
                ->andWhere('media_review.media = :mediaId')
                ->setParameter('mediaId', $mediaId)
                ->getQuery()
                ->getOneOrNullResult();

        return $res['avgRating'];
    }


}
