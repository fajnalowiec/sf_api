<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends AbstractController
{
    public function index(): JsonResponse
    {
        return $this->json(['message' => 'hello world']);
    }
}