<?php

namespace App\Shared\Domain\Entity;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Shared\Domain\ValueObject\Balance;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Shared\Domain\Repository\WalletRepository;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Wallet
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Embedded(class: Balance::class)]
    private Balance $balance;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: Operation::class, orphanRemoval: true)]
    #[OrderBy(["created_at" => "ASC"])]
    private Collection $operations;

    private Balance $_oldBalance;

    public function __construct(UuidInterface $id, string $name = null, Balance $balance = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
        $this->operations = new ArrayCollection();

        $this->_oldBalance = clone $balance;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBalance(): ?Balance
    {
        return $this->balance;
    }

    public function setBalance(Balance $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getOldBalance(): Balance
    {
        return $this->_oldBalance;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function increaseBalance(int $amount): self
    {
        $this->_oldBalance = clone $this->balance;
        $this->balance = $this->balance->increaseBalance($amount);

        return $this;
    }

    public function decreaseBalance(int $amount): self
    {
        $this->_oldBalance = clone $this->balance;
        $this->balance = $this->balance->decreaseBalance($amount);

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->created_at = new DateTimeImmutable("now");
        $this->updated_at = new DateTimeImmutable("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updated_at = new DateTimeImmutable("now");
    }
}
