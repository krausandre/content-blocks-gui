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

namespace ContentBlocks\ContentBlocksGui\Controller\Backend;

use ContentBlocks\ContentBlocksGui\Utility\ContentBlocksUtility;
use ContentBlocks\ContentBlocksGui\Utility\ExtensionUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\Controller;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

#[Controller]
final class ContentBlocksGuiAjaxController extends ActionController
{
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected PageRenderer $pageRenderer,
        protected ExtensionUtility $extensionUtility,
        protected ContentBlocksUtility $contentBlocksUtility,
    ) {
    }

    public function initializeAction(): void
    {
    }

    public function listCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $cbList = $this->contentBlocksUtility->getAvailableContentBlocks();
        return new JsonResponse(['success' => true, 'list' => $cbList]);
    }

    public function createCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        return new JsonResponse(['success' => true]);
    }

    public function getCbAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->contentBlocksUtility->getContentBlockByName(
            $request->getParsedBody()
        )->getResponse();
    }

    public function deleteCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        if(!isset($parsedBody['identifier'])) {
            return new JsonResponse(['success' => false, 'message' => 'No identifier given']);
        }
        $this->contentBlocksUtility->deleteContentBlockByIdentifier($parsedBody['identifier']);
        return new JsonResponse(['success' => true]);
    }
    public function translateAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        return new JsonResponse(['success' => true]);
    }
    public function saveCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        return new JsonResponse(['success' => true]);
    }
    public function downloadCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        if(!isset($parsedBody['identifier'])) {
            return new JsonResponse(['success' => false, 'message' => 'No identifier given']);
        }
        $fileName = $this->contentBlocksUtility->createZipFileFromContentBlockPath($parsedBody['identifier']);
        $response = $this->responseFactory
            ->createResponse()
            ->withAddedHeader('Content-Type', 'application/zip')
            ->withAddedHeader('Content-Length', (string)(filesize($fileName) ?: ''))
            ->withAddedHeader('Content-Disposition', 'attachment; filename="' . PathUtility::basename($fileName) . '"')
            ->withBody($this->streamFactory->createStreamFromFile($fileName));

        unlink($fileName);

        return $response;
    }
    public function copyCbAction(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        return new JsonResponse(['success' => true]);
    }
    public function listExtAction(ServerRequestInterface $request): ResponseInterface
    {
        $availableExtensions = $this->extensionUtility->getAvailableExtensions();
        return new JsonResponse(
            [
                'success' => true,
                'list' => $availableExtensions
            ]
        );
    }
}

