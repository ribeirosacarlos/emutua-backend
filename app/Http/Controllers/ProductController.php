<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API eMutua Produtos",
 *     description="Documentação da API do projeto eMutua",
 *     @OA\Contact(
 *         email="dev.carlosdesa@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Listar todos os produtos",
     *     description="Retorna uma lista de todos os produtos cadastrados",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos recuperada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        $data = array_map(fn($product) => $product->toArray(), $products);
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Buscar produto específico",
     *     description="Retorna os dados de um produto específico baseado no ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto (UUID)",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product->toArray());
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Criar novo produto",
     *     description="Cria um novo produto com os dados fornecidos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "price", "category"},
     *             @OA\Property(property="name", type="string", example="Smartphone XYZ"),
     *             @OA\Property(property="description", type="string", example="Um smartphone incrível"),
     *             @OA\Property(property="price", type="number", format="float", example=1299.99),
     *             @OA\Property(property="category", type="string", example="Eletrônicos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Atualizar produto",
     *     description="Atualiza os dados de um produto existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto (UUID)",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Smartphone XYZ Atualizado"),
     *             @OA\Property(property="description", type="string", example="Descrição atualizada do smartphone"),
     *             @OA\Property(property="price", type="number", format="float", example=1499.99),
     *             @OA\Property(property="category", type="string", example="Eletrônicos Premium")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Produto atualizado com sucesso"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Product"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Produto não encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o produto",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Erro ao atualizar o produto"),
     *             @OA\Property(property="error", type="string", example="Mensagem de erro detalhada")
     *         )
     *     )
     * )
     */
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

    
    /**
     * @OA\Delete(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Excluir produto",
     *     description="Remove um produto específico do sistema",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do produto (UUID)",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
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