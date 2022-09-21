<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
final class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $year = null;

    #[ORM\Column]
    private array $rating = [];

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    #[ORM\Column(length: 255)]
    private ?string $trailer = null;

    #[ORM\Column(type: Types::JSON)]
    private array $producer = [];

    #[ORM\ManyToMany(targetEntity: Gender::class)]
    private Collection $gender;

    public function __construct()
    {
        $this->gender = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getRating(): array
    {
        return $this->rating;
    }

    public function setRating(array $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getTrailer(): ?string
    {
        return $this->trailer;
    }

    public function setTrailer(string $trailer): self
    {
        $this->trailer = $trailer;

        return $this;
    }

    public function getProducer(): array
    {
        return $this->producer;
    }

    public function setProducer(array $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @return Collection<int, Gender>
     */
    public function getGender(): Collection
    {
        return $this->gender;
    }

    public function addGender(Gender $gender): self
    {
        if (!$this->gender->contains($gender)) {
            $this->gender->add($gender);
        }

        return $this;
    }

    public function removeGender(Gender $gender): self
    {
        $this->gender->removeElement($gender);

        return $this;
    }
}
