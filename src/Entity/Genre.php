<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(
        message: 'Veuillez renseigner le genre du livre.',
    )]
    private ?string $name = null;

    /**
     * @var Collection<int, books>
     */
    #[ORM\ManyToMany(targetEntity: books::class, inversedBy: 'genres')]
    #[Assert\Count(
        min: 1,
        minMessage: "Vous devez sélectionner au moins un libre.",
    )]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
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

    /**
     * @return Collection<int, books>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(books $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(books $book): static
    {
        $this->books->removeElement($book);

        return $this;
    }
}
