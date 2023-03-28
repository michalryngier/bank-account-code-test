<?php

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\Enum\Currency;

#[ORM\Embeddable]
class Balance
{
    #[ORM\Column]
    private int $value;

    public function __construct(
        int|string $value,
        #[ORM\Column(length: 3)]
        private readonly Currency $currency
    ) {
        if (is_string($value)) {
            $value = $this->parseStringValue($value);
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function toString(): string
    {
        return sprintf('%01.2f %s', ($this->getValue() / 100), $this->getCurrency()->name);
    }

    private function parseStringValue(string $value): int
    {
        $decimalPlaces = 2;
        $decimalMultiplier = 10;
        str_replace([','], ['.'], $value);

        return round(round($value, $decimalPlaces) * $decimalMultiplier);
    }

    public function increaseBalance(int $amount): self
    {
        $value = $this->value + $amount;

        return new self($value, $this->currency);
    }

    public function decreaseBalance(int $amount): self
    {
        $value = $this->value - $amount;

        return new self($value, $this->currency);
    }

    public function hasDifferentValue(Balance $balance): bool
    {
        return $this->value !== $balance->getValue();
    }

    public function hasDifferentCurrency(Balance $balance): bool
    {
        return $this->currency->value !== $balance->getCurrency()->name;
    }

    public function getValueDiff(Balance $balance): int
    {
        return abs($this->value - $balance->getValue());
    }
}