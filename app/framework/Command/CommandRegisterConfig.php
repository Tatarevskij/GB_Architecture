<?php

declare(strict_types = 1);

namespace Framework\Command;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Throwable;

class CommandRegisterConfig implements ICommand
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
        try {
            $fileLocator = new FileLocator($this->configPath);
            $loader = new PhpFileLoader($this->containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }
}