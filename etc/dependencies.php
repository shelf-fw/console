<?php

use Shelf\Console\Api\ShelfConsoleInterface;
use Shelf\Console\Factory\ConfigResolverFactory;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    ShelfConsoleInterface::SHELF_APPLICATION_KEY => [
        ShelfConsoleInterface::COMMANDS_KEY => [
            //Devcommits\App\Command\testCommand::class
        ]
    ]
];