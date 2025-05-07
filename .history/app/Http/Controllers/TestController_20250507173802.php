<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function testInsert()
    {
        $product = new Product();
        $product->setName('Produto de Teste');
        $product->setDescription('Descrição do produto de teste.');
        $product->setPrice(99.99);
        $product->setCategory('Teste');

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return "Produto inserido com ID: " . $product->getId();
    }
}