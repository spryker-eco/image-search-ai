<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Dependency\Client;

class ImageSearchAiToCatalogClientBridge implements ImageSearchAiToCatalogClientInterface
{
    /**
     * @var \Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClient;

    /**
     * @param \Spryker\Client\Catalog\CatalogClientInterface $catalogClient
     */
    public function __construct($catalogClient)
    {
        $this->catalogClient = $catalogClient;
    }

    /**
     * @param string $searchString
     * @param array<string, mixed> $requestParameters
     *
     * @return array<string, mixed>
     */
    public function catalogSuggestSearch(string $searchString, array $requestParameters = []): array
    {
        return $this->catalogClient->catalogSuggestSearch($searchString, $requestParameters);
    }
}
