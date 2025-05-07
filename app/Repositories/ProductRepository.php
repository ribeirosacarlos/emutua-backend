<?php

namespace App\Repositories;

use App\Entities\Product;
use Doctrine\ORM\EntityManager;

class ProductRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }

    public function find($id)
    {
        return $this->entityManager->find(Product::class, $id);
    }

    public function save(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }

    public function delete(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}