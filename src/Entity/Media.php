<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255,nullable: false)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duration = null;


    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'medias',cascade: ['persist'])]
    private Collection $genres;

    #[ORM\ManyToOne(targetEntity: Type::class, cascade: ['persist'], inversedBy: "medias")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'medias')]
    private Collection $staff;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediaReview::class, orphanRemoval: true)]
    private Collection $mediaReviews;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->mediaReviews = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Person $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
        }

        return $this;
    }

    public function removeStaff(Person $staff): static
    {
        $this->staff->removeElement($staff);

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection<int, MediaReview>
     */
    public function getMediaReviews(): Collection
    {
        return $this->mediaReviews;
    }

    public function addMediaReview(MediaReview $mediaReview): static
    {
        if (!$this->mediaReviews->contains($mediaReview)) {
            $this->mediaReviews->add($mediaReview);
            $mediaReview->setMedia($this);
        }

        return $this;
    }

    public function removeMediaReview(MediaReview $mediaReview): static
    {
        if ($this->mediaReviews->removeElement($mediaReview)) {
            // set the owning side to null (unless already changed)
            if ($mediaReview->getMedia() === $this) {
                $mediaReview->setMedia(null);
            }
        }

        return $this;
    }
}
