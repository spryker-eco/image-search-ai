<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
