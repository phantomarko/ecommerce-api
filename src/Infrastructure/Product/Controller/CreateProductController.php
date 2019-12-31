<?php

namespace App\Infrastructure\Product\Controller;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Product\Request\CreateProductRequest;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends AbstractController
{
    /**
     * @Post("/products")
     */
    public function postCreateProductAction(Request $request)
    {
        $request = new CreateProductRequest($request);
        $product = $this->commandBus->handle(new CreateProductCommand(
            $request->name(),
            $request->description(),
            $request->price(),
            $request->taxonomyUuid()
        ));

        return new JsonResponse($product, Response::HTTP_CREATED);
    }
}