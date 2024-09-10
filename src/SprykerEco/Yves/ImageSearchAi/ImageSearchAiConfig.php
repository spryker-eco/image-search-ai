<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @var string
     */
    protected const OPEN_AI_IMAGE_SEARCH_PROMPT = 'Describe the most important characteristics of the main object you can identify in the image e.g. manufacturer, model, color, part number or any identification number that help me to find the product using a search engine. Your output must be ony a list of the product attributes. Remove the attribute names and keep only the values from your output and provide them in a single line.';

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

    /**
     * @api
     *
     * @return string
     */
    public function getOpenAiImageSearchPrompt(): string
    {
        return static::OPEN_AI_IMAGE_SEARCH_PROMPT;
    }
}
