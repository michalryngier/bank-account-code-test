<?php

namespace App\WalletManagement\Application\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Shared\Application\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateWalletCommand implements CommandInterface
{
    public UuidInterface $id;

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 128)]
        public string $name,
        #[Assert\Length(exactly: 3)]
        public string $currency,
    )
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string UUID
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}