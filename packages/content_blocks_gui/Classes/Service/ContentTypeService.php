<?php

namespace ContentBlocks\ContentBlocksGui\Service;

use ContentBlocks\ContentBlocksGui\Answer\AnswerInterface;
use ContentBlocks\ContentBlocksGui\Answer\DataAnswer;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockConfiguration;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockSkeletonBuilder;
use TYPO3\CMS\ContentBlocks\Definition\ContentType\ContentType;
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\ContentBlocks\Service\CreateContentType;
use TYPO3\CMS\ContentBlocks\Service\PackageResolver;
use TYPO3\CMS\ContentBlocks\Utility\ContentBlockPathUtility;

class ContentTypeService
{
    public function __construct(
        protected readonly ContentBlockRegistry $contentBlockRegistry,
        protected readonly PackageResolver $packageResolver,
        protected readonly CreateContentType $createContentType,
        protected readonly ContentBlockSkeletonBuilder $contentBlockBuilder,
    ) {
    }
    public function getContentTypeData(array $getParsedBody): array
    {
        $data = [
            'contentType' => $getParsedBody['contentType'],
            'extension' => $getParsedBody['extension'],
            'mode' => $getParsedBody['mode'],
            'contentBlock' => [
                'vendor' => $getParsedBody['contentBlock']['vendor'],
                'name' => $getParsedBody['contentBlock']['name'],
            ]
        ];

        if($data['contentType'] === 'content-element') {
            $data['contentBlock']['fields'] = json_decode($getParsedBody['contentBlock']['fields'], true);
            $data['contentBlock']['basics'] = isset($getParsedBody['contentBlock']['basics']) ? json_decode($getParsedBody['contentBlock']['basics'], true) : [];
            $data['contentBlock']['group'] = $getParsedBody['contentBlock']['group'] ?? 'common';
            $data['contentBlock']['prefixFields'] = $getParsedBody['contentBlock']['prefixFields'] ?? true;
            $data['contentBlock']['prefixType'] = $getParsedBody['contentBlock']['prefixType'] ?? 'full';
            $data['contentBlock']['table'] = $getParsedBody['contentBlock']['table'] ?? 'tt_content';
            $data['contentBlock']['typeField'] = $getParsedBody['contentBlock']['typeField'] ?? 'CType';
        } else if($data['contentType'] === 'page-type') {
            $data['contentBlock']['type'] = $getParsedBody['contentBlock']['type'];
            $data['contentBlock']['prefixFields'] = $getParsedBody['contentBlock']['prefixFields'] ?? true;
            $data['contentBlock']['prefixType'] = $getParsedBody['contentBlock']['prefixType'] ?? 'full';
        } else if($data['contentType'] === 'record-type') {
            $data['contentBlock']['typeName'] = $getParsedBody['contentBlock']['typeName'] ?? '';
        }

        return $data;
    }

    public function createContentElement($data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];
        $yamlConfiguration = $this->createContentType->createContentBlockContentElementConfiguration(
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $data['contentBlock']['fields'],
            $data['contentBlock']['basics'],
            $data['contentBlock']['group'],
            $data['contentBlock']['prefixFields'],
            $data['contentBlock']['prefixType'],
            $data['contentBlock']['table'],
            $data['contentBlock']['typeField']
        );

        $this->createOrBuildContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::CONTENT_ELEMENT
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'content-element',
                'name' => $contentTypeName
            ]
        );
    }
    public function createPageType(array $data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];

        $yamlConfiguration = $this->createContentType->createContentBlockPageTypeConfiguration(
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $data['contentBlock']['type']
        );

        $this->createOrBuildContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::PAGE_TYPE
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'page-type',
                'name' => $contentTypeName
            ]
        );
    }

    public function createRecordType(array $data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];

        $yamlConfiguration = $this->createContentType->createContentBlockRecordTypeConfiguration(
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $data['contentBlock']['typeName']
        );

        $this->createOrBuildContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::RECORD_TYPE
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'record-type',
                'name' => $contentTypeName
            ]
        );
    }

    /**
     * @throws \RuntimeException
     */
    protected function createOrBuildContentType(
        string $mode,
        string $extension,
        string $vendor,
        string $name,
        array $yamlConfiguration,
        ContentType $contentType
    ): void {
        if($this->contentBlockRegistry->hasContentBlock($vendor . '/' . $name) && $mode === 'create') {
            throw new \RuntimeException('A content block with the name "' . $vendor . '/' . $name . '" already exists.');
        } else if($this->contentBlockRegistry->hasContentBlock($vendor . '/' . $name)) {
            $this->editContentType($yamlConfiguration, $name, $extension, $contentType);
        } else {
            $this->buildContentType($yamlConfiguration, $extension, $contentType);
        }
    }
    protected function buildContentType(array $yamlConfiguration, string $extension, ContentType $contentType): void
    {
        $contentBlockConfiguration = new ContentBlockConfiguration(
            yamlConfig: $yamlConfiguration,
            basePath: $this->createContentType->getBasePath(
                $this->packageResolver->getAvailablePackages(),
                $extension,
                $contentType
            ),
            contentType: $contentType
        );

        $this->contentBlockBuilder->create($contentBlockConfiguration);
    }

    protected function editContentType(array $yamlConfiguration, string $name, string $extension, ContentType $contentType): void
    {
        $basePath = $this->createContentType->getBasePath(
            $this->packageResolver->getAvailablePackages(),
            $extension,
            $contentType
        );
        file_put_contents(
            $basePath . '/' . $name . '/' . ContentBlockPathUtility::getContentBlockDefinitionFileName(),
            Yaml::dump($yamlConfiguration, 10, 2),
        );
    }
}
