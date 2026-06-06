<?php

class Inventario{
    
    public function __construct(Catalogo $catalogo){
        $productos = $catalogo;
    }

    public function ejecutar(string $instruccion): string{
        return "El inventario ha sido vaciado";
    }
}

interface Catalogo{
    public function getPrice(string $articulo): ?float;
}   