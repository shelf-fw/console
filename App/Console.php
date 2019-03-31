<?php

namespace Shelf\Console\App;
use Shelf\Framework\Api\AppInterface;
use Symfony\Component\Console\Application;
use Zend\ServiceManager\ServiceLocatorInterface;
use Shelf\Console\Api\ShelfConsoleInterface;

/**
 * Class Console
 * @package Shelf\Framework\App
 */
class Console implements AppInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

    /**
     * Console constructor.
     * @param ServiceLocatorInterface $serviceManager
     */
    public function __construct(ServiceLocatorInterface $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Launch application
     *
     */
    public function launch()
    {
        $config = $this->serviceManager->get('config');
        $applicationName = 'Shelf';
        $applicationVersion = '1.0.0';

        if (isset($config[ShelfConsoleInterface::SHELF_APPLICATION_KEY])) {
            $applicationName = isset($config[ShelfConsoleInterface::SHELF_APPLICATION_KEY]['application_name']) ?
                $config[ShelfConsoleInterface::SHELF_APPLICATION_KEY]['application_name'] : $applicationName;
            $applicationVersion = isset($config[ShelfConsoleInterface::SHELF_APPLICATION_KEY]['application_version']) ?
                $config[ShelfConsoleInterface::SHELF_APPLICATION_KEY]['application_name'] : $applicationVersion;
        }

        $application = new Application($applicationName, $applicationVersion);

        if (isset($config[ShelfConsoleInterface::SHELF_APPLICATION_KEY][ShelfConsoleInterface::COMMANDS_KEY])) {
            foreach ($config[ShelfConsoleInterface::SHELF_APPLICATION_KEY][ShelfConsoleInterface::COMMANDS_KEY] as $command) {
                $commandInstance = $this->serviceManager->has($command) ?
                    $this->serviceManager->get($command) : new $command;
                $application->add($commandInstance);
            }
        }

        return $application->run();
    }
}
