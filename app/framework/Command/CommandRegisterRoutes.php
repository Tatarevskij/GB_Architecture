<?php

declare(strict_types = 1);

namespace Framework\Command;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class CommandRegisterRoutes implements ICommand
{
    /**
     * @var string
     */
    private $configPath;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    /**
     * CommandRegisterConfig constructor.
     * @param string $configPath
     * @param ContainerBuilder $containerBuilder
     */
    public function __construct(string $configPath, ContainerBuilder $containerBuilder)
    {
        $this->configPath = $configPath;
        $this->containerBuilder = $containerBuilder;
    }


    /**
     * @inheritdoc
     */
    public function execute(): void
    {
        $routeCollection = require $this->configPath . DIRECTORY_SEPARATOR . 'routing.php';
        $this->containerBuilder->set('route_collection', $routeCollection);
    }
}