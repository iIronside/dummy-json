<?php

namespace Console\App\Commands;

use Console\App\Database\Models\Dimensions;
use Console\App\Database\Models\Image;
use Console\App\Database\Models\Meta;
use Console\App\Database\Models\Tag;
use Console\App\Database\Models\Product;
use Console\App\Database\Models\ProductTag;
use Console\App\Database\Models\Review;
use Console\App\Services\DummyApiService;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadProductCommand extends Command
{
    /**
     * @var DummyApiService
     */
    private $apiService;
    private const PRODUCT_ENDPOINT =  'products';
    private const CATEGORY_PRODUCT_ENDPOINT =  self::PRODUCT_ENDPOINT . '/category/';
    private const LIMIT = 30;

    public function __construct(DummyApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    protected function configure(): void
    {
        $this->setName('load-product')
            ->setDescription('Loads the list of products')
            ->setHelp('The team saves a list of products. Possible arguments: product category, product name')
            ->addArgument('category', InputArgument::OPTIONAL, 'Enter the product category.')
            ->addArgument('title', InputArgument::OPTIONAL, 'Enter the product title');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $category = $input->getArgument('category');
        $title = $input->getArgument('title');

        $output->writeln('Starting to download products');
        empty($category) ?: $output->writeln(sprintf('Product Category: %s', $category));
        empty($title) ?: $output->writeln(sprintf('Product Name: %s', $title));

        $endpoint = $category
            ? self::CATEGORY_PRODUCT_ENDPOINT . $category
            : self::PRODUCT_ENDPOINT;
        $skip = 0;

        do
        {
            $result = $this->apiService->load($endpoint, ['limit' => self::LIMIT, 'skip' => $skip]);

            foreach ($result['products'] as $product) {
                if (empty($title)) {
                    $this->saveProduct($product);
                } elseif (str_contains($product['title'], $title)) {
                    $this->saveProduct($product);
                }
            }

            $skip += count($result['products']);
            $output->writeln(sprintf('%s of %s products have been processed', $skip, $result['total']));
        } while ($skip < $result['total']);

        $output->writeln('Done!');
        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    private function saveProduct(array $product): void
    {
        $entityProduct = Product::updateOrCreate(
            ['title' => $product['title']],
            [
                'category' => $product['category'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'weight' => $product['weight'],
                'minimumOrderQuantity' => $product['minimumOrderQuantity'],
                'warranty_information' => $product['warrantyInformation'],
                'shipping_information' => $product['shippingInformation'],
                'availability_status' => $product['availabilityStatus'],
                'returnPolicy' => $product['returnPolicy'],
                'brand' => $product['brand'],
                'sku' => $product['sku'],
                'thumbnail' => $product['thumbnail'],
                'discount_percentage' => $product['discountPercentage'],
                'rating' => $product['rating'],
            ]
        );

        $tags = [];
        foreach ($product['tags'] as $tag) {
            $tags[] = Tag::firstOrCreate([
                'title' => $tag
            ]);
        }

        /** @var Tag $tag **/
        foreach ($tags as $tag) {
            ProductTag::firstOrCreate([
                'product_id' => $entityProduct->id,
                'tag_id' => $tag->id,
            ]);
        }

        Dimensions::updateOrCreate(
            ['product_id' => $entityProduct->id],
            [
                'width' => $product['dimensions']['width'],
                'height' => $product['dimensions']['height'],
                'depth' => $product['dimensions']['depth'],
            ]
        );

        foreach ($product['reviews'] as $review) {
            Review::updateOrCreate(
                [
                    'product_id' => $entityProduct->id,
                    'reviewer_name' => $review['reviewerName'],
                    'reviewer_email' => $review['reviewerEmail']
                ],
                [
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'date' => new DateTime($review['date'])
                ]
            );
        }

        Meta::updateOrCreate(
            ['product_id' => $entityProduct->id],
            [
                'barcode' => $product['meta']['barcode'],
                'qr_code' => $product['meta']['qrCode'],
                'updated_at' => new DateTime($product['meta']['updatedAt']),
                'created_at' => new DateTime($product['meta']['createdAt']),
            ]
        );

        foreach ($product['images'] as $image) {
            Image::updateOrCreate(
                ['product_id' => $entityProduct->id],
                ['url' => $image]
            );
        }
    }
}
