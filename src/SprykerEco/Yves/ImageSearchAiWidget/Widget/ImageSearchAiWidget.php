<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAiWidget\Widget;

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
        return '@ImageSearchAiWidget/views/image-search-ai/image-search-ai.twig';
    }
}
