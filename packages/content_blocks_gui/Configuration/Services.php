<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

 namespace ContentBlocks\ContentBlocksGui;

use ContentBlocks\ContentBlocksGui\Factory\UsageFactory;
use ContentBlocks\ContentBlocksGui\Domain\Repository\ContentElementRepository;
use ContentBlocks\ContentBlocksGui\Domain\Repository\PageTypeRepository;
use ContentBlocks\ContentBlocksGui\Domain\Repository\RecordTypeRepository;
use ContentBlocks\ContentBlocksGui\Utility\ContentBlocksUtility;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function (ContainerConfigurator $configurator, ContainerBuilder $containerBuilder) {
    $services = $configurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->load('ContentBlocks\\ContentBlocksGui\\', __DIR__ . '/../Classes/')->exclude([
        __DIR__ . '/../Classes/Domain/Model',
    ]);

    $services->set(ContentBlocksUtility::class)
        ->arg('$usageFactory', service(UsageFactory::class));

    $services->set(UsageFactory::class)
        ->args([
            service(PageTypeRepository::class),
            service(RecordTypeRepository::class),
            service(ContentElementRepository::class),
        ]);

};
