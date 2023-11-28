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

namespace ContentBlocks\ContentBlocksGui\Utility;

use TYPO3\CMS\ContentBlocks\Service\PackageResolver;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

class ExtensionUtility
{
    public function __construct(
        protected PackageResolver $packageResolver
    ) {
    }
    public function getAvailableExtensions(): array
    {
        // TODO: test in legacy mode
        $availablePackages = $this->packageResolver->getAvailablePackages();
        $availableExtensions = [];
        foreach ($availablePackages as $packageKey => $package) {

            if($package->getValueFromComposerManifest('name') === 'contentblocks/content-blocks-gui') {
                continue;
            }

            $requiredPackages = $package->getValueFromComposerManifest('require');
            $requiredContentBlocksPackage = false;
            foreach ($requiredPackages as $package => $version) {
                if($package === 'contentblocks/content-blocks' || $package === 'typo3/cms-content-blocks') {
                    $requiredContentBlocksPackage = true;
                }
            }
            if(!$requiredContentBlocksPackage) {
                continue;
            }
            $availableExtensions[] = [
                'vendor' => explode('/', $availablePackages[$packageKey]->getValueFromComposerManifest('name'))[0],
                'package' => explode('/', $availablePackages[$packageKey]->getValueFromComposerManifest('name'))[1],
                'extension' => $packageKey,
                'icon' => PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::getExtensionIcon($availablePackages[$packageKey]->getPackagePath(), true))
            ];
        }
        return $availableExtensions;
    }
}