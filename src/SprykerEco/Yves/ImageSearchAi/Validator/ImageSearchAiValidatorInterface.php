<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Validator;

interface ImageSearchAiValidatorInterface
{
    /**
     * @param array<string, mixed> $requestBodyContent
     *
     * @return bool
     */
    public function validate(array $requestBodyContent): bool;
}
