<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductSeeder extends Seeder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function run(): void
    {
        $productsData = [
            [
                'name' => 'Produto A',
                'description' => 'Descrição do Produto A',
                'price' => 19.99,
                'category' => 'Categoria 1',
            ],
            [
                'name' => 'Produto B',
                'description' => 'Descrição do Produto B',
                'price' => 29.99,
                'category' => 'Categoria 2',
            ],
            [
                'name' => 'Produto C',
                'description' => 'Descrição do Produto C',
                'price' => 39.99,
                'category' => 'Categoria 1',
            ],
        ];

        foreach ($productsData as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setCategory($data['category']);

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
    }
}
