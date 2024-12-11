<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Dependency\Client;

interface ImageSearchAiToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array<string, mixed> $requestParameters
     *
     * @return array<string, mixed>
     */
    public function catalogSuggestSearch(string $searchString, array $requestParameters = []): array;
}
