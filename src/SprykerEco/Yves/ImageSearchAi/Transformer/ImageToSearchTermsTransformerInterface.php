<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
