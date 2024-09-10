<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\ImageSearchAi\Controller;

use Generated\Shared\Transfer\ImageSearchFindTermsErrorMessageTransfer;
use Generated\Shared\Transfer\ImageSearchFindTermsErrorResponseTransfer;
use Generated\Shared\Transfer\ImageSearchFindTermsResponseTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;

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
     * @var string
     */
    protected const REQUEST_BODY_CONTENT_KEY_TOKEN = '_token';

    /**
     * @var string
     */
    protected const CSRF_TOKEN_ID = 'image_search_ai_csrf';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function findTermsAction(Request $request): JsonResponse
    {
        $requestBodyContent = $this->getFactory()
            ->getUtilEncodingService()
            ->decodeJson((string)$request->getContent(), true);

        if (
            !isset($requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]) ||
            !$this->getFactory()->getCsrfTokenManager()->isTokenValid(
                new CsrfToken(static::CSRF_TOKEN_ID, $requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]),
            )
        ) {
            return $this->createAjaxErrorResponse([
                'error' => 'form.csrf.error.text',
            ], Response::HTTP_BAD_REQUEST);
        }

        unset($requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_TOKEN]);

        $errors = $this->getFactory()->createBase64ImageValidator()->validate($requestBodyContent);
        if (count($errors)) {
            $errorResponse = new ImageSearchFindTermsErrorResponseTransfer();
            $errorResponse->setError('Bad request');
            foreach ($errors as $error) {
                $errorMessage = new ImageSearchFindTermsErrorMessageTransfer();
                $errorMessage->setMessage($error->getMessage());
                $errorResponse->addImageSearchFindTermsErrorMessage($errorMessage);
            }

            return new JsonResponse($errorResponse->toArray(), Response::HTTP_BAD_REQUEST);
        }

        $searchString = $this->getFactory()->createImageToSearchTermsTransformer()->transform(
            $requestBodyContent[static::REQUEST_BODY_CONTENT_KEY_IMAGE],
        )->getMessage();

        if (!$searchString) {
            return new JsonResponse((new ImageSearchFindTermsResponseTransfer())->toArray());
        }

        $searchResults = $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSuggestSearch($searchString, []);

        return new JsonResponse([
            'searchUrl' => Url::generate('/search', ['q' => $searchString])->build(),
            'firstMatchProductUrl' => Url::generate($searchResults['suggestionByType']['product_abstract'][0]['url'])->build(),
        ]);
    }

    /**
     * @param array<string, mixed> $errorData
     * @param int $statusCode
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function createAjaxErrorResponse(array $errorData, int $statusCode): JsonResponse
    {
        return $this->jsonResponse($errorData, $statusCode);
    }
}
