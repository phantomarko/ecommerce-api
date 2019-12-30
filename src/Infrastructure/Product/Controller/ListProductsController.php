<?php

namespace App\Infrastructure\Product\Controller;

use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Infrastructure\Common\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListProductsController extends AbstractController
{
    /**
     * @Get("/products")
     */
    public function getProductsAction()
    {
        // TODO Add request
        $products = $this->commandBus->handle(new GetProductsCommand());
        return new JsonResponse($products);
    }
}