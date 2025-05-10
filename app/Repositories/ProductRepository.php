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
        return $this->entityManager
            ->getRepository(Product::class)
            ->findAll();
    }

    public function find($id)
    {
        return $this->entityManager
            ->find(Product::class, $id);
    }

    public function findByName(string $name): ?Product
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(["name"=> $name]);
    }

    public function save(Product $product)
    {
        try {
            $this->entityManager->beginTransaction();

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->entityManager->commit();

            return $product;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function delete(Product $product)
    {
        try {

            $this->entityManager->beginTransaction();

            $this->entityManager->remove($product);
            $this->entityManager->flush();

            $this->entityManager->commit();
            
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}