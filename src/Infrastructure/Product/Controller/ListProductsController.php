<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Common\Service\ResponseCreator;
use App\Infrastructure\Product\Service\SymfonyRequestToGetProductsCommandConverter;
use FOS\RestBundle\Controller\Annotations\Get;
use League\Tactician\CommandBus;
use Swagger\Annotations as SWG;
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
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     description="The page"
     * )
     * @SWG\Parameter(
     *     name="itemsPerPage",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     description="The items per page"
     * )
     * @SWG\Parameter(
     *     name="taxonomyUuid",
     *     in="query",
     *     type="string",
     *     required=false,
     *     description="The taxonomy uuid"
     * )
     * @SWG\Parameter(
     *     name="minimumPrice",
     *     in="query",
     *     type="number",
     *     required=false,
     *     description="The minimum price"
     * )
     * @SWG\Parameter(
     *     name="maximumPrice",
     *     in="query",
     *     type="number",
     *     required=false,
     *     description="The maximum price"
     * )
     * @SWG\Parameter(
     *     name="text",
     *     in="query",
     *     type="string",
     *     required=false,
     *     description="The text to look for in the name and description fields"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Fetch products success"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Request error"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Internal server error"
     * )
     * @SWG\Tag(name="Products")
     */
    public function getProductsAction(Request $request)
    {
        $command = $this->requestToCommandConverter->convert($request);
        $products = $this->commandBus->handle($command);

        return $this->responseCreator->create(
            $products,
            'Products fetched successfully.',
            Response::HTTP_OK
        );
    }
}