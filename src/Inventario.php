<?php

class Inventario{
    private Catalogo $catalogo;
    public function __construct(Catalogo $catalogo){

        $this->catalogo = $catalogo;
    }

    public function ejecutar(string $instruccion): string{

    $partesInstruccion = explode(" ",$instruccion);
    $accion = strtolower($partesInstruccion[0]);
    $producto = strtolower($partesInstruccion[1] ?? " ");

    if($accion === "cuenta"){

        return "Total: 0.00";
    }
    elseif($accion === "añadir"){

        $precio = $this->catalogo->getPrecio($producto);

        if($precio!==null){
            return "$producto x1";
        }
    }

    return "El inventario ha sido vaciado";
    }
}

interface Catalogo{
    public function getPrecio(string $articulo): ?float;
}   