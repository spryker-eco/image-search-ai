<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToCatalogClientBridge;
use SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientBridge;
use SprykerEco\Yves\ImageSearchAi\Dependency\Service\ImageSearchAiToUtilEncodingServiceBridge;

/**
 * @method \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig getConfig()
 */
class ImageSearchAiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CATALOG = 'CLIENT_CATALOG';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const CLIENT_OPEN_AI = 'CLIENT_OPEN_AI';

    /**
     * @var string
     */
    public const SERVICE_FORM_CSRF_PROVIDER = 'form.csrf_provider';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCatalogClient($container);
        $container = $this->addOpenAiClient($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addCsrfProviderService($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCatalogClient(Container $container): Container
    {
        $container->set(static::CLIENT_CATALOG, function (Container $container) {
                return new ImageSearchAiToCatalogClientBridge($container->getLocator()->catalog()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
                return new ImageSearchAiToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addOpenAiClient(Container $container): Container
    {
        $container->set(static::CLIENT_OPEN_AI, function (Container $container) {
                return new ImageSearchAiToOpenAiClientBridge($container->getLocator()->openAi()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCsrfProviderService(Container $container): Container
    {
        $container->set(static::SERVICE_FORM_CSRF_PROVIDER, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_FORM_CSRF_PROVIDER);
        });

        return $container;
    }
}
