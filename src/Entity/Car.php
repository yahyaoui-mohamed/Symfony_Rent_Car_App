<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['car_details'])]
    private ?int $id = null;

    #[Groups(['car_details'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['car_details'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['car_details'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['car_details'])]
    #[ORM\Column]
    private ?int $capacity = null;

    #[Groups(['car_details'])]
    #[ORM\Column(length: 255)]
    private ?string $steering = null;

    #[Groups(['car_details'])]
    #[ORM\Column]
    private ?int $gasoline = null;

    #[Groups(['car_details'])]
    #[ORM\Column]
    private ?int $price = null;

    #[Groups(['car_details'])]
    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[Groups(['car_details'])]
    #[ORM\Column(nullable: true)]
    private ?int $old_price = null;

    /**
     * @var Collection<int, Favorite>
     */
    #[Groups(['car_details'])]
    #[ORM\OneToMany(targetEntity: Favorite::class, mappedBy: 'car', orphanRemoval: true)]
    private Collection $favorites;

    /**
     * @var Collection<int, Transaction>
     */
    #[Groups(['car_details'])]
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'car')]
    private Collection $transactions;

    #[Groups(['car_details'])]
    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $other_img = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'car', orphanRemoval: true)]
    private Collection $reviews;
    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSteering(): ?string
    {
        return $this->steering;
    }

    public function setSteering(string $steering): static
    {
        $this->steering = $steering;

        return $this;
    }

    public function getGasoline(): ?int
    {
        return $this->gasoline;
    }

    public function setGasoline(int $gasoline): static
    {
        $this->gasoline = $gasoline;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getOldPrice(): ?int
    {
        return $this->old_price;
    }

    public function setOldPrice(?int $old_price): static
    {
        $this->old_price = $old_price;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setCar($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getCar() === $this) {
                $favorite->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setCar($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCar() === $this) {
                $transaction->setCar(null);
            }
        }

        return $this;
    }

    public function getOtherImg(): ?array
    {
        return $this->other_img;
    }

    public function setOtherImg(?array $other_img): static
    {
        $this->other_img = $other_img;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setCar($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCar() === $this) {
                $review->setCar(null);
            }
        }

        return $this;
    }
}
