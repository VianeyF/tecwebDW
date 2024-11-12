<?php

namespace MyApi\Models;

class Product
{
    private int $id; 
    private string $nombre;
    private float $precio;
    private string $detalles;
    private string $marca;
    private string $modelo;
    private int $unidades;
    private int $eliminado;  // Indica el estado de eliminación lógica (0: activo, 1: eliminado)

    public function __construct(
        string $nombre,
        float $precio,
        string $detalles,
        string $marca,
        string $modelo,
        int $unidades,
        int $eliminado = 0  // Valor por defecto 0 al crear un producto
    ) {
        $this->id = 0; 
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->detalles = $detalles;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->unidades = $unidades;
        $this->eliminado = $eliminado;
    }

    // Métodos getter y setter para cada propiedad
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getDetalles(): string
    {
        return $this->detalles;
    }

    public function setDetalles(string $detalles): void
    {
        $this->detalles = $detalles;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
    }

    public function getUnidades(): int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): void
    {
        $this->unidades = $unidades;
    }

    public function getEliminado(): int
    {
        return $this->eliminado;
    }

    public function setEliminado(int $eliminado): void
    {
        $this->eliminado = $eliminado;
    }
}
