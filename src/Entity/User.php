<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email(
        message: 'L\'adresse email {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Les rôles ne peuvent pas être vides.',
    )]
    #[Assert\All(
        constraints: [
            new Assert\NotBlank(message: 'Chaque rôle doit être non vide.'),
            new Assert\Choice(
                choices: ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'],
                message: 'Le rôle {{ value }} n\'est pas valide.',
            ),
        ]
    )]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Le mot de passe ne peut pas être vide.',
    )]
    #[Assert\Length(
        min: 8,
        max: 255,
        minMessage: 'Le mot de passe doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.',
    )]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le prénom doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères.',
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom de famille doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le nom de famille ne peut pas dépasser {{ limit }} caractères.',
    )]
    private ?string $lastname = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'user')]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
