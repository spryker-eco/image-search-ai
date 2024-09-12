<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
    protected ImageSearchAiConfig $imageSearchAiConfig;

    /**
     * @param \SprykerEco\Yves\ImageSearchAi\Dependency\Client\ImageSearchAiToOpenAiClientInterface $openAiClient
     * @param \SprykerEco\Yves\ImageSearchAi\ImageSearchAiConfig $imageSearchAiConfig
     */
    public function __construct(
        ImageSearchAiToOpenAiClientInterface $openAiClient,
        ImageSearchAiConfig $imageSearchAiConfig
    ) {
        $this->openAiClient = $openAiClient;
        $this->imageSearchAiConfig = $imageSearchAiConfig;
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
                'text' => $this->imageSearchAiConfig->getOpenAiImageSearchPrompt(),
            ],
            [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $base64Image,
                ],
            ],
        ])->setModel($this->imageSearchAiConfig->getOpenAiModel());

        return $this->openAiClient->chat($openAiChatRequestTransfer);
    }
}
