<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 64)]
    private ?string $login = null;

    #[ORM\Column(length: 64)]
    private ?string $password = null;

    #[ORM\Column(length: 256, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, UserShoppingList>
     */
    #[ORM\OneToMany(targetEntity: UserShoppingList::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $userShoppingLists;

    public function __construct()
    {
        $this->userShoppingLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, UserShoppingList>
     */
    public function getUserShoppingLists(): Collection
    {
        return $this->userShoppingLists;
    }

    public function addUserShoppingList(UserShoppingList $userShoppingList): static
    {
        if (!$this->userShoppingLists->contains($userShoppingList)) {
            $this->userShoppingLists->add($userShoppingList);
            $userShoppingList->setUser($this);
        }

        return $this;
    }

    public function removeUserShoppingList(UserShoppingList $userShoppingList): static
    {
        if ($this->userShoppingLists->removeElement($userShoppingList)) {
            // set the owning side to null (unless already changed)
            if ($userShoppingList->getUser() === $this) {
                $userShoppingList->setUser(null);
            }
        }

        return $this;
    }
}
