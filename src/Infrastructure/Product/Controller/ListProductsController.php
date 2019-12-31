<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Product\Service\SymfonyRequestToGetProductsCommand;
use FOS\RestBundle\Controller\Annotations\Get;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListProductsController extends AbstractController
{
    private $requestToGetProductsCommand;

    public function __construct(
        CommandBus $commandBus,
        SymfonyRequestToGetProductsCommand $requestToGetProductsCommand
    )
    {
        parent::__construct($commandBus);
        $this->requestToGetProductsCommand = $requestToGetProductsCommand;
    }

    /**
     * @Get("/products")
     */
    public function getProductsAction(Request $request)
    {
        $command = $this->requestToGetProductsCommand->convert($request);
        $products = $this->commandBus->handle($command);
        return new JsonResponse($products);
    }
}