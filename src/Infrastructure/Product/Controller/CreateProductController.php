<?php

namespace App\Infrastructure\Product\Controller;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Infrastructure\Common\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends AbstractController
{
    /**
     * @Post("/products")
     */
    public function postCreateProductAction()
    {
        $product = $this->commandBus->handle(new CreateProductCommand(
            'iPhone Xs',
            'iPhone Xs 64GB Space Gray',
            799.99,
            '656853f2-2b9a-11ea-b9eb-080027c2e88e'
        ));

        return new JsonResponse($product, Response::HTTP_CREATED);
    }
}