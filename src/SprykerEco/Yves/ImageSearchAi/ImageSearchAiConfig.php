<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi;

use Spryker\Yves\Kernel\AbstractBundleConfig;

class ImageSearchAiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const OPEN_AI_GPT4O_MINI_MODEL = 'gpt-4o-mini';

    /**
     * @api
     *
     * @return array<string>
     */
    public function getAllowedMimeTypes(): array
    {
        return [
            'image/jpeg',
            'image/png',
        ];
    }

    /**
     * @api
     *
     * @return string
     */
    public function getOpenAiModel(): string
    {
        return static::OPEN_AI_GPT4O_MINI_MODEL;
    }
}
