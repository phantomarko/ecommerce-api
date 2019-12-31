<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Product\Service\SymfonyRequestToCreateProductCommand;
use FOS\RestBundle\Controller\Annotations\Post;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends AbstractController
{
    private $requestToCreateProductCommand;

    public function __construct(
        CommandBus $commandBus,
        SymfonyRequestToCreateProductCommand $requestToCreateProductCommand
    )
    {
        parent::__construct($commandBus);
        $this->requestToCreateProductCommand = $requestToCreateProductCommand;
    }

    /**
     * @Post("/products")
     */
    public function postCreateProductAction(Request $request)
    {
        $command = $this->requestToCreateProductCommand->convert($request);
        $product = $this->commandBus->handle($command);

        return new JsonResponse($product, Response::HTTP_CREATED);
    }
}