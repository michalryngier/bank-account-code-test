<?php

namespace App\Shared\Domain\Entity;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Enum\OperationType;
use App\Shared\Domain\ValueObject\OperationData;
use App\Shared\Domain\Repository\OperationRepository;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Operation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private ?UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Wallet::class, inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $wallet;

    #[ORM\Column(length: 255)]
    private ?OperationType $type;

    #[ORM\Embedded(class: OperationData::class, columnPrefix: 'operation_data_')]
    private ?OperationData $operationData;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    public function __construct(
        UuidInterface $id,
        ?Wallet $wallet,
        ?OperationType $type,
        ?OperationData $operationData
    )
    {
        $this->id = $id;
        $this->wallet = $wallet;
        $this->type = $type;
        $this->operationData = $operationData;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): ?OperationType
    {
        return $this->type;
    }

    public function setType(OperationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getOpeationData(): ?OperationData
    {
        return $this->operationData;
    }

    public function setOpeationData(OperationData $operationData): self
    {
        $this->operationData = $operationData;

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
