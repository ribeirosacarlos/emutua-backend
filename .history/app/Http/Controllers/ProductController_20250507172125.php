<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return response()->json($products);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100'
        ]);

        $product = new Product();
        $product->setName($request->name);
        $product->setDescription($request->description);
        $product->setPrice($request->price);
        $product->setCategory($request->category);

        $this->productRepository->save($product);

        return response()->json($product, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'category' => 'string|max:100'
        ]);

        if ($request->has('name')) {
            $product->setName($request->name);
        }
        if ($request->has('description')) {
            $product->setDescription($request->description);
        }
        if ($request->has('price')) {
            $product->setPrice($request->price);
        }
        if ($request->has('category')) {
            $product->setCategory($request->category);
        }

        $this->productRepository->save($product);

        return response()->json($product);
    }

    public function destroy(string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $this->productRepository->delete($product);

        return response()->json(null, 204);
    }
}