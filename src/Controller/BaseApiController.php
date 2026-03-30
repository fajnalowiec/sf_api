<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends AbstractController
{
    protected function prepareErrorResponse(
            string $errorMsg,
            int $httpStatusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->json(['error' => $errorMsg], $httpStatusCode);
    }

}