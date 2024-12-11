<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Validator;

use SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Base64ImageValidator implements Base64ImageValidatorInterface
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig
     */
    protected ImageSearchAiConfig $imageSearchAiConfig;

    /**
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig $imageSearchAiConfig
     */
    public function __construct(
        ValidatorInterface $validator,
        ImageSearchAiConfig $imageSearchAiConfig
    ) {
        $this->validator = $validator;
        $this->imageSearchAiConfig = $imageSearchAiConfig;
    }

    /**
     * @param array<string, string> $imageContent
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate(array $imageContent): ConstraintViolationListInterface
    {
        $constraint = new Collection(
            $this->getBase64ImageFieldValidationConstraints(),
        );

        return $this->validator->validate($imageContent, $constraint);
    }

    /**
     * @return array<string, array<int, \Symfony\Component\Validator\Constraint>>
     */
    protected function getBase64ImageFieldValidationConstraints(): array
    {
        return [
            'image' => [
                new NotBlank(),
                new Callback(['callback' => [$this, 'validateIsBase64']]),
            ],
        ];
    }

    /**
     * @param mixed $value
     * @param \Symfony\Component\Validator\Context\ExecutionContextInterface $context
     *
     * @return void
     */
    public function validateIsBase64(mixed $value, ExecutionContextInterface $context): void
    {
        $value = preg_replace('#data:image/[^;]+;base64,#', '', $value);

        $decodedFile = base64_decode($value);
        if (!$decodedFile) {
            $context->buildViolation('This is not a base64 file')
                ->atPath('image')
                ->addViolation();
        }

        $tmpFilename = tempnam(sys_get_temp_dir(), 'guessMimeType_');
        file_put_contents($tmpFilename, $decodedFile);
        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($tmpFilename);
        unlink($tmpFilename);

        if (!in_array($mimeType, $this->imageSearchAiConfig->getAllowedMimeTypes(), true)) {
            $context->buildViolation(sprintf(
                'Invalid mime type %s. Accepted types are %s.',
                $mimeType,
                implode(', ', $this->imageSearchAiConfig->getAllowedMimeTypes()),
            ))
                ->atPath('image')
                ->addViolation();
        }
    }
}
