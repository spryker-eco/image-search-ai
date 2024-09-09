<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToCatalogClientInterface;
use SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface;
use SprykerEco\Yves\ImageSearchAi\Dependency\Service\ImageSearchAiToUtilEncodingServiceInterface;
use SprykerEco\Yves\ImageSearchAi\Transformer\ImageToSearchTermsTransformer;
use SprykerEco\Yves\ImageSearchAi\Validator\Base64ImageValidator;
use SprykerEco\Yves\ImageSearchAi\Validator\Base64ImageValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig getConfig()
 */
class ImageSearchAiFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Yves\ImageSearchAi\Transformer\ImageToSearchTermsTransformer
     */
    public function createImageToSearchTermsTransformer(): ImageToSearchTermsTransformer
    {
        return new ImageToSearchTermsTransformer(
            $this->getOpenAiClient(),
            $this->getConfig(),
        );
    }

    /**
     * @return \SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToCatalogClientInterface
     */
    public function getCatalogClient(): ImageSearchAiToCatalogClientInterface
    {
        return $this->getProvidedDependency(ImageSearchAiDependencyProvider::CLIENT_CATALOG);
    }

    /**
     * @return \SprykerEco\Yves\ImageSearchAi\Dependency\Service\ImageSearchAiToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): ImageSearchAiToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ImageSearchAiDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \SprykerEco\Yves\ImageSearchAi\Validator\Base64ImageValidatorInterface
     */
    public function createBase64ImageValidator(): Base64ImageValidatorInterface
    {
        return new Base64ImageValidator(
            $this->createValidator(),
            $this->getConfig(),
        );
    }

    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public function createValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }

    /**
     * @return \SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface
     */
    public function getOpenAiClient(): ImageSearchAiToOpenAiClientInterface
    {
        return $this->getProvidedDependency(ImageSearchAiDependencyProvider::CLIENT_OPEN_AI);
    }

    /**
     * @return \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface
     */
    public function getCsrfTokenManager(): CsrfTokenManagerInterface
    {
        return $this->getProvidedDependency(ImageSearchAiDependencyProvider::SERVICE_FORM_CSRF_PROVIDER);
    }
}
