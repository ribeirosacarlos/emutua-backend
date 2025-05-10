<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;

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
        $data = array_map(fn($product) => $product->toArray(), $products);
        return response()->json($data);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product->toArray());
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $product = new Product();
            $product->setName($request->name);
            $product->setDescription($request->description);
            $product->setPrice($request->price);
            $product->setCategory($request->category);
    
            $savedProduct = $this->productRepository->save($product);
    
            return response()->json([
                'success' => true,
                'message' => 'Produto criado com sucesso',
                'data' => $savedProduct->toArray()
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar o produto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $product = $this->productRepository->find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produto não encontrado'
                ], 404);
            }

            $product->setName($request->name);
            if ($request->has('description')) $product->setDescription($request->description);
            if ($request->has('price')) $product->setPrice($request->price);
            if ($request->has('category')) $product->setCategory($request->category);

            $updatedProduct = $this->productRepository->save($product);

            return response()->json([
                'success' => true,
                'message' => 'Produto atualizado com sucesso',
                'data' => $updatedProduct->toArray()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o produto',
                'error' => $e->getMessage()
            ], 500);
        }
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