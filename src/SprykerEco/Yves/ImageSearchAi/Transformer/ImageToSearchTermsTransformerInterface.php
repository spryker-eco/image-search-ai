<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Transformer;

use Generated\Shared\Transfer\OpenAiChatResponseTransfer;

interface ImageToSearchTermsTransformerInterface
{
    /**
     * @param string $base64Image
     *
     * @return \Generated\Shared\Transfer\OpenAiChatResponseTransfer
     */
    public function transform(string $base64Image): OpenAiChatResponseTransfer;
}
