<?php

class Inventario{
    private Catalogo $catalogo;
    private array $articulos = []; 
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

    if($accion === "añadir"){

        $precio = $this->catalogo->getPrecio($producto);

        if($precio!==null){

                $this->articulos[$producto] = 1;
        }
        
        return $this->listarInventario($this->articulos);
        }

    return "El inventario ha sido vaciado";
    }

    private function listarInventario(array $inventario):string{
        ksort($inventario,SORT_REGULAR);

        $textos = [];
        foreach($inventario as $nombre => $cantidad) {

            $textos[] = "$nombre x$cantidad";
        }
        
        return implode(', ', $textos);

    }
}

interface Catalogo{
    public function getPrecio(string $articulo): ?float;
}   