<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Controller;

use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \SprykerEco\Yves\ImageSearchAi\ImageSearchAiFactory getFactory()
 */
class ImageSearchController extends AbstractController
{
    /**
     * @var string
     */
    protected const REQUEST_BODY_CONTENT_KEY_IMAGE = 'image';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function findTermsAction(Request $request): JsonResponse
    {
        $requestContent = (string)$request->getContent();

        if (!$requestContent) {
            return $this->createAjaxErrorResponse();
        }

        $requestBodyContent = $this->getFactory()
            ->getUtilEncodingService()
            ->decodeJson($requestContent, true);

        if (!is_array($requestBodyContent)) {
            return $this->createAjaxErrorResponse();
        }

        $isRequestValid = $this->getFactory()
            ->createImageSearchAiValidator()
            ->validate($requestBodyContent);

        if (!$isRequestValid) {
            return $this->createAjaxErrorResponse();
        }

        $searchString = $this->getFactory()->createImageToSearchTermsTransformer()->transform(
            $requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_IMAGE],
        )->getMessage();

        if (!$searchString) {
            return $this->jsonResponse();
        }

        $searchResults = $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSuggestSearch($searchString, []);

        return new JsonResponse([
            'success' => true,
            'firstMatchProductUrl' => !empty($searchResults['suggestionByType']['product_abstract'][0]['url'])
                ? Url::generate($searchResults['suggestionByType']['product_abstract'][0]['url'])->build()
                : '',
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function createAjaxErrorResponse(): JsonResponse
    {
        return $this->jsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
    }
}
