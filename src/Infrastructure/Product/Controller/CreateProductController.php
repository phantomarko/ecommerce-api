<?php

namespace App\Infrastructure\Product\Controller;

use App\Infrastructure\Common\Controller\AbstractController;
use App\Infrastructure\Common\Service\ResponseCreator;
use App\Infrastructure\Product\Service\SymfonyRequestToCreateProductCommandConverter;
use FOS\RestBundle\Controller\Annotations\Post;
use League\Tactician\CommandBus;
use Swagger\Annotations as SWG;
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
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Product data (taxonomyUuid is opcional)",
     *     format="application/json",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              property="name",
     *              type="string",
     *              description="Required field."
     *          ),
     *          @SWG\Property(
     *              property="description",
     *              type="string",
     *              description="Required field."
     *          ),
     *          @SWG\Property(
     *              property="price",
     *              type="number",
     *              description="Required field."
     *          ),
     *          @SWG\Property(
     *              property="taxonomyUuid",
     *              type="string",
     *              description="Taxonomy uuid. Optional field."
     *          ),
     *          @SWG\Property(
     *              property="base64Image",
     *              type="string",
     *              description="Image in base64 with mime type metadata. Required field."
     *          )
     *     )
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Create product success."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Request error."
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Internal server error."
     * )
     * @SWG\Tag(name="Products")
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