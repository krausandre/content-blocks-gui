<?php

namespace ContentBlocks\ContentBlocksGui\Domain\Repository;

use TYPO3\CMS\ContentBlocks\Definition\ContentType\ContentType;

interface UsageInterface
{
    public function countUsages(string|int $name, ContentType $contentType, string $tableName): int;
}
