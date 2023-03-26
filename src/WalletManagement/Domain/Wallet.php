<?php

namespace App\WalletManagement\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use App\WalletManagement\Domain\Balance;
use Doctrine\ORM\Mapping as ORM;
use App\WalletManagement\Domain\WalletRepository;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?UuidInterface $id;

    #[ORM\Column(length: 255)]
    private ?string $name;

    #[ORM\Embedded(class: Balance::class)]
    private ?Balance $balance;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    public function __construct(UuidInterface $id, ?string $name = null, ?Balance $balance = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }
}
