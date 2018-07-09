<?php

namespace App\UserInterface\Rest\Symfony;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SanityController extends Controller
{
    /**
     * @Route("/", name="sanity_test")
     */
    public function index()
    {
        return new JsonResponse(['Sanity test okay']);
    }
}
