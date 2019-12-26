<?php

namespace App\Infrastructure\Product\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListProductsController
{
    /**
     * @Get("/products")
     */
    public function indexAction()
    {
        return new JsonResponse(['data'=>'hola']);
    }
}