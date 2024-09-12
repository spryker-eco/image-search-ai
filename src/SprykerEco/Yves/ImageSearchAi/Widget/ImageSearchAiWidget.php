<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Widget;

use Spryker\Yves\Kernel\Widget\AbstractWidget;

class ImageSearchAiWidget extends AbstractWidget
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'ImageSearchAiWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ImageSearchAi/views/image-search-ai/image-search-ai.twig';
    }
}
