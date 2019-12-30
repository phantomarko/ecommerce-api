<?php

namespace App\Infrastructure\Product\Controller;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Infrastructure\Common\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends AbstractController
{
    /**
     * @Post("/products")
     */
    public function postCreateProductAction()
    {
        $product = $this->commandBus->handle(new CreateProductCommand());
        return new JsonResponse($product, Response::HTTP_CREATED);
    }
}