<?php

namespace Tests\Unit\Domain\Entities;

use App\Entities\Product;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase 
{
    private Product $product;
    private string $validName = 'Test Product';
    private string $validDescription = 'Test Description';
    private float $validPrice = 99.99;
    private string $validCategory = 'Electronics';

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    /** @test */
    public function it_should_create_a_valid_product(): void
    {
        $this->assertInstanceOf(Product::class, $this->product);
        $this->assertNotEmpty($this->product->getId());
        $this->assertTrue(strlen($this->product->getId()) === 36, 'ID should be a UUID with 36 characters');
    }

    /** @test */
    public function it_should_not_accept_empty_name(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setName('');
    }

    /** @test */
    public function it_should_not_accept_name_longer_than_255_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setName(str_repeat('a', 256));
    }

    /** @test */
    public function it_should_set_and_get_valid_name(): void
    {
        $this->product->setName($this->validName);
        $this->assertEquals($this->validName, $this->product->getName());
    }

    /** @test */
    public function it_should_not_accept_empty_description(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setDescription('');
    }

    /** @test */
    public function it_should_set_and_get_valid_description(): void
    {
        $this->product->setDescription($this->validDescription);
        $this->assertEquals($this->validDescription, $this->product->getDescription());
    }

    /** @test */
    public function it_should_not_accept_negative_price(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setPrice(-1.0);
    }

    /** @test */
    public function it_should_not_accept_zero_price(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setPrice(0.0);
    }

    /** @test */
    public function it_should_set_and_get_valid_price(): void
    {
        $this->product->setPrice($this->validPrice);
        $this->assertEquals($this->validPrice, $this->product->getPrice());
    }

    /** @test */
    public function it_should_not_accept_empty_category(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setCategory('');
    }

    /** @test */
    public function it_should_not_accept_category_longer_than_100_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->product->setCategory(str_repeat('a', 101));
    }

    /** @test */
    public function it_should_set_and_get_valid_category(): void
    {
        $this->product->setCategory($this->validCategory);
        $this->assertEquals($this->validCategory, $this->product->getCategory());
    }

    /** @test */
    public function it_should_convert_to_array_with_correct_structure(): void
    {
        $this->product->setName($this->validName);
        $this->product->setDescription($this->validDescription);
        $this->product->setPrice($this->validPrice);
        $this->product->setCategory($this->validCategory);

        $array = $this->product->toArray();

        $expectedKeys = ['id', 'name', 'description', 'price', 'category'];
        
        // Verifica se todas as chaves esperadas existem
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $array);
        }

        // Verifica se não há chaves extras
        $this->assertEquals(count($expectedKeys), count($array));

        // Verifica os valores
        $this->assertEquals($this->validName, $array['name']);
        $this->assertEquals($this->validDescription, $array['description']);
        $this->assertEquals($this->validPrice, $array['price']);
        $this->assertEquals($this->validCategory, $array['category']);
    }

    /** @test */
    public function it_should_create_product_with_valid_data(): void
    {
        $product = new Product();
        $product->setName($this->validName)
                ->setDescription($this->validDescription)
                ->setPrice($this->validPrice)
                ->setCategory($this->validCategory);

        $this->assertEquals($this->validName, $product->getName());
        $this->assertEquals($this->validDescription, $product->getDescription());
        $this->assertEquals($this->validPrice, $product->getPrice());
        $this->assertEquals($this->validCategory, $product->getCategory());
    }
}