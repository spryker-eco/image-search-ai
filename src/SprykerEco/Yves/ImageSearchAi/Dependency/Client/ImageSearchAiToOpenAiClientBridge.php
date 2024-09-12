<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Dependency\Client;

use Generated\Shared\Transfer\OpenAiChatRequestTransfer;
use Generated\Shared\Transfer\OpenAiChatResponseTransfer;

class ImageSearchAiToOpenAiClientBridge implements ImageSearchAiToOpenAiClientInterface
{
    /**
     * @var \SprykerEco\Client\OpenAi\OpenAiClientInterface
     */
    protected $openAiClient;

    /**
     * @param \SprykerEco\Client\OpenAi\OpenAiClientInterface $openAiClient
     */
    public function __construct($openAiClient)
    {
        $this->openAiClient = $openAiClient;
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiChatRequestTransfer $openAiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiChatResponseTransfer
     */
    public function chat(OpenAiChatRequestTransfer $openAiRequestTransfer): OpenAiChatResponseTransfer
    {
        return $this->openAiClient->chat($openAiRequestTransfer);
    }
}
