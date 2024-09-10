<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface Base64ImageValidatorInterface
{
    /**
     * @param array<string, string> $imageContent
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate(array $imageContent): ConstraintViolationListInterface;
}
