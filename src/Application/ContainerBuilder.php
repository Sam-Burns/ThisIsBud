<?php
namespace SamBurns\ThisIsBud\Application;

use Pimple\Container;

class ContainerBuilder
{
    public function buildContainer(): Container
    {
        $container = new Container(
            include __DIR__ . '/../../config/di.php'
        );

        return $container;
    }
}
