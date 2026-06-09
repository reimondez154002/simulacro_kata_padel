<?php

class Inventario{
    public $catalogo;
    public function __construct(Catalogo $catalogo){

        $this->catalogo = $catalogo;
    }

    public function ejecutar(string $instruccion): string{

    if($instruccion === "cuenta"){
        
        return "Total: 0.00";
    }

    return "El inventario ha sido vaciado";
    }
}

interface Catalogo{
    public function getPrecio(string $articulo): ?float;
}   