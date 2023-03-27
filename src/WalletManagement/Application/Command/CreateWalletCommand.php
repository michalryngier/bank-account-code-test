<?php

namespace App\WalletManagement\Application\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use App\Shared\Domain\Enum\Currency;
use App\Shared\Application\CommandInterface;
use App\Shared\Domain\ValueObject\Balance\Balance;
use Symfony\Component\Validator\Constraints as Assert;
use App\Shared\Domain\ValueObject\Balance\BalanceFactory;
use App\Shared\Domain\Exception\CurrencyNotSupportedException;

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

    /**
     * @throws CurrencyNotSupportedException
     */
    public function getBalance(): Balance
    {
        $currency = Currency::tryFrom($this->currency);
        $currencyNotSupported = is_null($currency);
        CurrencyNotSupportedException::throwWhen($currencyNotSupported, $this->currency);

        return (new BalanceFactory($currency))->createBalance();
    }
}