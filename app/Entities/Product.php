<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(type: 'string', length: 100)]
    private string $category;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    // Setters
    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Nome não pode ser vazio');
        }
        if (strlen($name) > 255) {
            throw new \InvalidArgumentException('Nome não pode ter mais de 255 characters');
        }
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        // if (empty($description)) {
        //     throw new \InvalidArgumentException('A descrição não pode ser vazia');
        // }
        if (strlen($description) < 10) {
            throw new \InvalidArgumentException('A descrição tem que ter mais de 10 characters');
        }
        $this->description = $description;
        return $this;
    }

    public function setPrice(float $price): self
    {
        if ($price <= 0) {
            throw new \InvalidArgumentException('Preço deve ser maior que zero');
        }
        $this->price = $price;
        return $this;
    }

    public function setCategory(string $category): self
    {
        if (empty($category)) {
            throw new \InvalidArgumentException('A categoria não pode ser vazia');
        }
        if (strlen($category) > 100) {
            throw new \InvalidArgumentException('A categoria pode ter no máximo 100 characters');
        }
        $this->category = $category;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'category' => $this->getCategory(),
        ];
    }
}