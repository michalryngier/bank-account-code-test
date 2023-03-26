<?php

namespace App\WalletManagement\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Balance
{
    #[ORM\Column]
    private int $value;

    public function __construct(
        int|string $value,
        #[ORM\Column(type: 'string', length: 3)]
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

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function isEqual(Balance $other): bool
    {
        return $this->currency === $other->getCurrency() && $this->value === $other->getValue();
    }

    public function toString(): string
    {
        return sprintf('%01.2f %s', ($this->value / 100), $this->currency->name);
    }

    private function parseStringValue(string $value): int
    {
        $decimalPlaces = 2;
        $decimalMultiplier = 10;
        str_replace([','], ['.'], $value);

        return round(round($value, $decimalPlaces) * $decimalMultiplier);
    }
}