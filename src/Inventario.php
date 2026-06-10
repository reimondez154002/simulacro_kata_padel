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
    $cantidad = (int)($partesInstruccion[2] ?? 1);

    if($accion === "cuenta"){

        return "Total: 0.00";
    }

    if($accion === "añadir"){

        $precio = $this->catalogo->getPrecio($producto);
        if($precio===null){
            return "El articulo no existe en el catalogo";
        }

        if(isset($this->articulos[$producto])){
            $this->articulos[$producto] = $this->articulos[$producto] + $cantidad;
        }
        else{
            $this->articulos[$producto] = $cantidad;
        }
        
        return $this->listarInventario($this->articulos);
    }

    if($accion === "vaciar"){
        $this->articulos = [];

        return "El inventario ha sido vaciado";
    }

    if($accion === "eliminar"){
        if(isset($this->articulos[$producto])){
            unset($this->articulos[$producto]);

            return $this->listarInventario($this->articulos);
        }
        
        return "El elemento a eliminar no esta en el inventario";
    }
    return "Accion no reconocida";
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