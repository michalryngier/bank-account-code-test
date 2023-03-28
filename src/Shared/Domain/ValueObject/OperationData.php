<?php

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class OperationData
{
    #[ORM\Embedded(class: Balance::class, columnPrefix: 'balance_before_')]
    private Balance $balanceBefore;

    #[ORM\Embedded(class: Balance::class, columnPrefix: 'balance_after_')]
    private Balance $balanceAfter;

    public function __construct(Balance $balanceBefore, Balance $balanceAfter)
    {
        $this->balanceBefore = $balanceBefore;
        $this->balanceAfter = $balanceAfter;
    }

    public function getBalanceBefore(): ?Balance
    {
        return $this->balanceBefore;
    }

    public function setBalanceBefore(Balance $balanceBefore): self
    {
        $this->balanceBefore = $balanceBefore;

        return $this;
    }

    public function getBalanceAfter(): ?Balance
    {
        return $this->balanceAfter;
    }

    public function setBalanceAfter(Balance $balanceAfter): self
    {
        $this->balanceAfter = $balanceAfter;

        return $this;
    }
}