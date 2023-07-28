<?php

namespace Maris\Symfony\Direction;

use Maris\Symfony\Direction\DependencyInjection\DirectionExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DirectionBundle extends AbstractBundle{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DirectionExtension();
    }
    /*public function getPath(): string
    {
        return dirname(__DIR__);
    }*/
}