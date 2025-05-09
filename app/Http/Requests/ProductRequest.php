<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Repositories\ProductRepository;

class ProductRequest extends FormRequest
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    // Implementar auth
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Verifica se já existe um produto com o mesmo nome
                    $existingProduct = $this->productRepository->findByName($value);
                    
                    if ($existingProduct && (!$this->route('id') || $this->route('id') !== $existingProduct->getId())) {
                        $fail('Este nome de produto já está em uso.');
                    }
                }
            ],
            'description' => 'required|string|min:10',
            'price' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'category' => [
                'required',
                'string',
                'max:100'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do produto é obrigatório',
            'name.max' => 'O nome do produto não pode ter mais que 255 caracteres',
            'description.required' => 'A descrição do produto é obrigatória',
            'description.min' => 'A descrição deve ter pelo menos 10 caracteres',
            'price.required' => 'O preço do produto é obrigatório',
            'price.numeric' => 'O preço deve ser um valor numérico',
            'price.min' => 'O preço não pode ser negativo',
            'price.regex' => 'O preço deve ter no máximo duas casas decimais',
            'category.required' => 'A categoria do produto é obrigatória',
            'category.max' => 'A categoria não pode ter mais que 100 caracteres'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
