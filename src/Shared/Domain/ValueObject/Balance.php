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

    private function parseStringValue(string $value): int
    {
        $decimalPlaces = 2;
        $decimalMultiplier = 10;
        str_replace([','], ['.'], $value);

        return round(round($value, $decimalPlaces) * $decimalMultiplier);
    }
}