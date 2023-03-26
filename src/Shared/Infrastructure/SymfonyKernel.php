<?php

namespace App\Shared\Infrastructure;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class SymfonyKernel extends BaseKernel
{
    use MicroKernelTrait;
}
