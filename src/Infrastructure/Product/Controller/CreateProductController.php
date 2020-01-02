<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Common\Service\ResponseCreator;
use App\Infrastructure\Product\Service\SymfonyRequestToCreateProductCommandConverter;
use FOS\RestBundle\Controller\Annotations\Post;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends AbstractController
{
    private $requestToCommandConverter;
    private $responseCreator;

    public function __construct(
        CommandBus $commandBus,
        SymfonyRequestToCreateProductCommandConverter $symfonyRequestToCreateProductCommandConverter,
        ResponseCreator $responseCreator
    )
    {
        parent::__construct($commandBus);
        $this->requestToCommandConverter = $symfonyRequestToCreateProductCommandConverter;
        $this->responseCreator = $responseCreator;
    }

    /**
     * @Post("/products")
     */
    public function postCreateProductAction(Request $request)
    {
        $command = $this->requestToCommandConverter->convert($request);
        $product = $this->commandBus->handle($command);

        return $this->responseCreator->create(
            $product,
            'Product created successfully.',
            Response::HTTP_CREATED
        );
    }
}