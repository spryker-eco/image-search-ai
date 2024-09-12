<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Validator;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ImageSearchAiValidator implements ImageSearchAiValidatorInterface
{
    /**
     * @var string
     */
    protected const REQUEST_BODY_CONTENT_KEY_TOKEN = '_token';

    /**
     * @var string
     */
    protected const CSRF_TOKEN_ID = 'image_search_ai_csrf';

    /**
     * @var \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface
     */
    protected CsrfTokenManagerInterface $csrfTokenManager;

    /**
     * @var \SprykerEco\Yves\ImageSearchAi\Validator\Base64ImageValidatorInterface
     */
    protected Base64ImageValidatorInterface $base64ImageValidator;

    /**
     * @param \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $csrfTokenManager
     * @param \SprykerEco\Yves\ImageSearchAi\Validator\Base64ImageValidatorInterface $base64ImageValidator
     */
    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        Base64ImageValidatorInterface $base64ImageValidator
    ) {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->base64ImageValidator = $base64ImageValidator;
    }

    /**
     * @param array<string, mixed> $requestBodyContent
     *
     * @return bool
     */
    public function validate(array $requestBodyContent): bool
    {
        return $this->isCsrfTokenValid($requestBodyContent) &&
            $this->isBase64ImageValid($requestBodyContent);
    }

    /**
     * @param array<string, mixed> $requestBodyContent
     *
     * @return bool
     */
    protected function isCsrfTokenValid(array $requestBodyContent): bool
    {
        return isset($requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]) &&
            $this->csrfTokenManager->isTokenValid(
                new CsrfToken(static::CSRF_TOKEN_ID, $requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]),
            );
    }

    /**
     * @param array<string, mixed> $requestBodyContent
     *
     * @return bool
     */
    protected function isBase64ImageValid(array $requestBodyContent): bool
    {
        unset($requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]);

        $errors = $this->base64ImageValidator->validate($requestBodyContent);

        if (count($errors)) {
            return false;
        }

        return true;
    }
}
