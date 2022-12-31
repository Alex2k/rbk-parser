<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class BaseController extends AbstractController
{
    private JsonResponse $successResponse;

    /**
     * @throws Throwable
     */
    protected function handler(Request $request/*, ApiActionInterface $action*/, array $context = [], array $data = []): JsonResponse
    {
        $responseData = $this->execute($request, $context, $data);

        if (isset($responseData['errors']) && count($responseData['errors'])) {
            return $this->failureResponse($responseData);
        }

        return $this->successResponse($responseData);
    }

    protected function successResponse(array $data): JsonResponse
    {
        if (isset($this->successResponse)) {
            return $this->successResponse;
        }

        return $this->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function failureResponse(array $data): JsonResponse
    {
        return $this->json([
            'success' => false,
            'errors' => $data['errors'],
        ]);
    }

    protected function setSuccessResponse(array $data = []): void
    {
        $this->successResponse = $this->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
