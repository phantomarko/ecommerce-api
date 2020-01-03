<?php

namespace App\Application\Product\Service;

use App\Domain\Common\Service\ImageUrlGeneratorInterface;
use App\Domain\Product\Model\Product;

class ProductToArrayConverter
{
    private $imageUrlGenerator;

    public function __construct(ImageUrlGeneratorInterface $imageUrlGenerator)
    {
        $this->imageUrlGenerator = $imageUrlGenerator;
    }

    public function convert(Product $product, string $hostUrl): array
    {
        return [
            'uuid' => $product->uuid(),
            'name' => $product->name(),
            'description' => $product->description(),
            'price' => $product->price(),
            'priceWithVat' => $product->priceWithVat(),
            'taxonomyName' => $product->taxonomyName(),
            'image' => $this->imageUrlGenerator->generate($hostUrl, $product->imageRelativePath())
        ];
    }
}