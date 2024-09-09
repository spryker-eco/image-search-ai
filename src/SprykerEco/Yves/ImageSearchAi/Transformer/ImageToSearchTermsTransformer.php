<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Transformer;

use Generated\Shared\Transfer\OpenAiChatRequestTransfer;
use Generated\Shared\Transfer\OpenAiChatResponseTransfer;
use SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface;
use SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig;

class ImageToSearchTermsTransformer implements ImageToSearchTermsTransformerInterface
{
    /**
     * @var \SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface
     */
    protected ImageSearchAiToOpenAiClientInterface $openAiClient;

    /**
     * @var \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig
     */
    protected ImageSearchAiConfig $config;

    /**
     * @param \SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface $openAiClient
     * @param \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig $imageSearchAiConfig
     */
    public function __construct(
        ImageSearchAiToOpenAiClientInterface $openAiClient,
        ImageSearchAiConfig $imageSearchAiConfig
    ) {
        $this->openAiClient = $openAiClient;
        $this->config = $imageSearchAiConfig;
    }

    /**
     * @param string $base64Image
     *
     * @return \Generated\Shared\Transfer\OpenAiChatResponseTransfer
     */
    public function transform(string $base64Image): OpenAiChatResponseTransfer
    {
        $openAiChatRequestTransfer = (new OpenAiChatRequestTransfer())->setPromptData([
            [
                'type' => 'text',
                'text' => 'Describe the most important characteristics of the main object you can identify in the image e.g. manufacturer, model, color, part number or any identification number that help me to find the product using a search engine. Your output must be ony a list of the product attributes. Remove the attribute names and keep only the values from your output and provide them in a single line.',
            ],
            [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $base64Image,
                ],
            ],
        ])->setModel($this->config->getOpenAiModel());

        return $this->openAiClient->chat($openAiChatRequestTransfer);
    }
}
