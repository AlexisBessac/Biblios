<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le contenu du commentaire ne peut pas être vide.',
    )]
    #[Assert\Length(
        min: 5,
        max: 1000,
        minMessage: 'Le commentaire doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le commentaire ne peut pas dépasser {{ limit }} caractères.',
    )]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[Assert\NotNull(
        message: 'Le commentaire doit être associé à un utilisateur.',
    )]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[Assert\NotNull(
        message: 'Le commentaire doit être associé à un livre.',
    )]
    private ?books $books = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBooks(): ?books
    {
        return $this->books;
    }

    public function setBooks(?books $books): static
    {
        $this->books = $books;

        return $this;
    }
}
