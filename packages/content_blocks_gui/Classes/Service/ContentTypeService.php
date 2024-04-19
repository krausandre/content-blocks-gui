<?php

namespace ContentBlocks\ContentBlocksGui\Service;

use ContentBlocks\ContentBlocksGui\Answer\AnswerInterface;
use ContentBlocks\ContentBlocksGui\Answer\DataAnswer;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockConfiguration;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockSkeletonBuilder;
use TYPO3\CMS\ContentBlocks\Definition\ContentType\ContentType;
use TYPO3\CMS\ContentBlocks\Loader\ContentBlockLoader;
use TYPO3\CMS\ContentBlocks\Loader\LoadedContentBlock;
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\ContentBlocks\Service\CreateContentType;
use TYPO3\CMS\ContentBlocks\Service\PackageResolver;
use TYPO3\CMS\ContentBlocks\Utility\ContentBlockPathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentTypeService
{
    public function __construct(
        protected readonly ContentBlockRegistry $contentBlockRegistry,
        protected readonly PackageResolver $packageResolver,
        protected readonly CreateContentType $createContentType,
        protected readonly ContentBlockSkeletonBuilder $contentBlockBuilder,
        protected readonly ContentBlockLoader $contentBlockLoader,
    ) {
    }

    public function getContentTypeData(array $getParsedBody): array
    {
        $data = [
            'contentType' => $getParsedBody['contentType'],
            'extension' => $getParsedBody['extension'],
            'mode' => $getParsedBody['mode'],
            'contentBlock' => [
                'vendor' => explode('/', $getParsedBody['name'] ?? 'test/foobar')[0],
                'name' => explode('/', $getParsedBody['name'] ?? 'test/foobar')[1]
            ]
        ];

        if($getParsedBody['mode'] === 'copy') {
            $data['contentBlock']['initialVendor'] = $getParsedBody['initialVendor'];
            $data['contentBlock']['initialName'] = $getParsedBody['initialName'];
        }

        // TODO: Maybe extract title, priority, etc out of the if statement, as this is used for all three content types
        if($data['contentType'] === 'content-element') {
            $data['contentBlock']['fields'] = $getParsedBody['contentBlock']['fields'] ?? [];
            $data['contentBlock']['basics'] = $getParsedBody['contentBlock']['basics'] ?? [];
            $data['contentBlock']['group'] = $getParsedBody['contentBlock']['group'] ?? 'common';
            $data['contentBlock']['prefixFields'] = $getParsedBody['contentBlock']['prefixFields'] ?? true;
            $data['contentBlock']['prefixType'] = $getParsedBody['contentBlock']['prefixType'] ?? 'full';
            $data['contentBlock']['table'] = $getParsedBody['contentBlock']['table'] ?? 'tt_content';
            $data['contentBlock']['typeField'] = $getParsedBody['contentBlock']['typeField'] ?? 'CType';
            $data['contentBlock']['priority'] = $getParsedBody['contentBlock']['priority'] ?? 0;
            $data['contentBlock']['title'] = $getParsedBody['contentBlock']['title'] ?? '';
            $data['contentBlock']['vendorPrefix'] = $getParsedBody['contentBlock']['vendorPrefix'] ?? '';
        } else if($data['contentType'] === 'page-type') {
            $data['contentBlock']['type'] = $getParsedBody['contentBlock']['type'];
            $data['contentBlock']['prefixFields'] = $getParsedBody['contentBlock']['prefixFields'] ?? true;
            $data['contentBlock']['prefixType'] = $getParsedBody['contentBlock']['prefixType'] ?? 'full';
        } else if($data['contentType'] === 'record-type') {
            $data['contentBlock']['typeName'] = $getParsedBody['contentBlock']['typeName'] ?? '';
        } else if($data['contentType'] === 'basic') {
            $data['contentBlock']['fields'] = $getParsedBody['contentBlock']['fields'];
        }

        return $data;
    }

    public function handleContentElement($data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];
        $yamlConfiguration = $this->createContentType->createContentBlockContentElementConfiguration(
            vendor: $data['contentBlock']['vendor'],
            name: $data['contentBlock']['name'],
            title: $data['contentBlock']['title'],
            fields: $data['contentBlock']['fields'],
            basics: $data['contentBlock']['basics'],
            group: $data['contentBlock']['group'],
            prefixFields: !($data['contentBlock']['prefixFields'] == 'false'),
            prefixType: $data['contentBlock']['prefixType'],
            vendorPrefix: $data['contentBlock']['vendorPrefix'],
            table: $data['contentBlock']['table'],
            typeField: $data['contentBlock']['typeField'],
            priority: $data['contentBlock']['priority']
        );

        $this->handleContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::CONTENT_ELEMENT,
            $data['contentBlock']['initialVendor'] ?? '',
            $data['contentBlock']['initialName'] ?? '',
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'content-element',
                'name' => $contentTypeName
            ]
        );
    }
    public function handlePageType(array $data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];

        $yamlConfiguration = $this->createContentType->createContentBlockPageTypeConfiguration(
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $data['contentBlock']['type']
        );

        $this->handleContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::PAGE_TYPE,
            $data['contentBlock']['initialVendor'] ?? '',
            $data['contentBlock']['initialName'] ?? '',
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'page-type',
                'name' => $contentTypeName
            ]
        );
    }

    public function handleRecordType(array $data): AnswerInterface
    {
        $contentTypeName = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];

        $yamlConfiguration = $this->createContentType->createContentBlockRecordTypeConfiguration(
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $data['contentBlock']['typeName']
        );

        $this->handleContentType(
            $data['mode'],
            $data['extension'],
            $data['contentBlock']['vendor'],
            $data['contentBlock']['name'],
            $yamlConfiguration,
            ContentType::RECORD_TYPE,
            $data['contentBlock']['initialVendor'] ?? '',
            $data['contentBlock']['initialName'] ?? '',
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'record-type',
                'name' => $contentTypeName
            ]
        );
    }

    public function handleBasic(array $data): AnswerInterface
    {
        $identifier = $data['contentBlock']['vendor'] . '/' . $data['contentBlock']['name'];
        $yamlConfiguration['identifier'] = $identifier;
        $yamlConfiguration['fields'] = $data['contentBlock']['fields'];

        $availablePackages = $this->packageResolver->getAvailablePackages();
        $basePath = $availablePackages[$data['extension']]->getPackagePath() . ContentBlockPathUtility::getRelativeBasicsPath();

        $basicsFileName = ucfirst($data['contentBlock']['name']) . '.yaml';

        if(!is_dir($basePath)) {
            mkdir($basePath, 0775, true);
        }
        file_put_contents(
            $basePath . '/' . $basicsFileName,
            Yaml::dump($yamlConfiguration, 10, 2),
        );

        return new DataAnswer(
            'contentType',
            [
                'type' => 'basic',
                'identifier' => $identifier
            ]
        );
    }

    /**
     * @throws \RuntimeException
     */
    protected function handleContentType(
        string $mode,
        string $extension,
        string $vendor,
        string $name,
        array $yamlConfiguration,
        ContentType $contentType,
        string $initialVendor = '',
        string $initialName = '',
    ): void {
        if($this->contentBlockRegistry->hasContentBlock($vendor . '/' . $name) && $mode === 'create') {
            throw new \RuntimeException('A content block with the name "' . $vendor . '/' . $name . '" already exists.');
        } else if($this->contentBlockRegistry->hasContentBlock($vendor . '/' . $name) && $mode === 'edit') {
            $this->editContentType($yamlConfiguration, $name, $extension, $contentType);
        } else if($mode === 'copy') {
            if($this->contentBlockRegistry->hasContentBlock($vendor . '/' . $name)) {
                throw new \RuntimeException('A content block with the name "' . $vendor . '/' . $name . '" already exists.');
            }
            if(!$this->contentBlockRegistry->hasContentBlock($initialVendor . '/' . $initialVendor)) {
                throw new \RuntimeException('The initial content block with the name "' . $initialVendor . '/' . $initialVendor . '" doesn\'t exists.');
            }
            $this->copyContentType($yamlConfiguration, $name, $initialVendor . '/' . $initialName, $extension, $contentType);
        } else {
            $this->buildContentType($yamlConfiguration, $extension, $contentType);
        }
        $this->contentBlockLoader->loadUncached();
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
        $filename = $basePath . '/' . $name . '/' . ContentBlockPathUtility::getContentBlockDefinitionFileName();
        file_put_contents(
            $basePath . '/' . $name . '/' . ContentBlockPathUtility::getContentBlockDefinitionFileName(),
            Yaml::dump($yamlConfiguration, 10, 2),
        );
    }

    protected function copyContentType(
        array $yamlConfiguration,
        string $name,
        string $initialName,
        string $extension,
        ContentType $contentType
    ): void {
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

        $initialContentBlock = $this->contentBlockRegistry->getContentBlock($initialName);

        $createdContentBlock = new LoadedContentBlock(
            name: $name,
            yaml: $yamlConfiguration,
            icon: $initialContentBlock->getIcon(),
            iconProvider: $initialContentBlock->getIconProvider(),
            hostExtension: $extension,
            extPath: ContentBlockPathUtility::getContentBlockExtPath($extension, $contentBlockConfiguration->getName(), $contentType),
            contentType: $contentType
        );

        // get files and folders from initial content block and add/overwrite them in new content block
        $this->copyContentBlockFilesAndFolders(
            GeneralUtility::getFileAbsFileName($initialContentBlock->getExtPath()),
            GeneralUtility::getFileAbsFileName($createdContentBlock->getExtPath())
        );
    }

    protected function copyContentBlockFilesAndFolders($source, $destination): void
    {
        if (is_dir($source)) {
            @mkdir($destination);
            $directory = dir($source);
            while (false !== ($entry = $directory->read())) {
                if ($entry == '.' || $entry == '..' || $entry === 'EditorInterface.yaml') {
                    continue;
                }
                $this->copyContentBlockFilesAndFolders("$source/$entry", "$destination/$entry");
            }
            $directory->close();
        } else {
            copy($source, $destination);
        }
    }
}
