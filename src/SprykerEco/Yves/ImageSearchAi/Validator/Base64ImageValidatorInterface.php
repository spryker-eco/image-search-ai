<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

interface Base64ImageValidatorInterface
{
    /**
     * @param array<string, string> $requestBodyContent
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate(array $requestBodyContent): ConstraintViolationListInterface;
}
