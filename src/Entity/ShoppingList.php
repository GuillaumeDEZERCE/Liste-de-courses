<?php

namespace App\Entity;

use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, UserShoppingList>
     */
    #[ORM\OneToMany(targetEntity: UserShoppingList::class, mappedBy: 'shoppingList', orphanRemoval: true)]
    private Collection $userShoppingLists;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'shoppingList', orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->userShoppingLists = new ArrayCollection();
        $this->items = new ArrayCollection();
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
            $userShoppingList->setShoppingList($this);
        }

        return $this;
    }

    public function removeUserShoppingList(UserShoppingList $userShoppingList): static
    {
        if ($this->userShoppingLists->removeElement($userShoppingList)) {
            // set the owning side to null (unless already changed)
            if ($userShoppingList->getShoppingList() === $this) {
                $userShoppingList->setShoppingList(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setShoppingList($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getShoppingList() === $this) {
                $item->setShoppingList(null);
            }
        }

        return $this;
    }
}
