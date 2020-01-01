<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Common\Service\ResponseCreator;
use App\Infrastructure\Product\Service\SymfonyRequestToGetProductsCommandConverter;
use FOS\RestBundle\Controller\Annotations\Get;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListProductsController extends AbstractController
{
    private $requestToCommandConverter;
    private $responseCreator;

    public function __construct(
        CommandBus $commandBus,
        SymfonyRequestToGetProductsCommandConverter $symfonyRequestToGetProductsCommandConverter,
        ResponseCreator $responseCreator
    )
    {
        parent::__construct($commandBus);
        $this->requestToCommandConverter = $symfonyRequestToGetProductsCommandConverter;
        $this->responseCreator = $responseCreator;
    }

    /**
     * @Get("/products")
     */
    public function getProductsAction(Request $request)
    {
        $command = $this->requestToCommandConverter->convert($request);
        $products = $this->commandBus->handle($command);

        return $this->responseCreator->create(
            $products,
            'Products fetched successfully',
            Response::HTTP_OK
        );
    }
}