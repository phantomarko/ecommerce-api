<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Product\Service\SymfonyRequestToGetProductsCommandConverter;
use FOS\RestBundle\Controller\Annotations\Get;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListProductsController extends AbstractController
{
    private $requestToCommandConverter;

    public function __construct(
        CommandBus $commandBus,
        SymfonyRequestToGetProductsCommandConverter $symfonyRequestToGetProductsCommandConverter
    )
    {
        parent::__construct($commandBus);
        $this->requestToCommandConverter = $symfonyRequestToGetProductsCommandConverter;
    }

    /**
     * @Get("/products")
     */
    public function getProductsAction(Request $request)
    {
        $command = $this->requestToCommandConverter->convert($request);
        $products = $this->commandBus->handle($command);
        return new JsonResponse($products);
    }
}