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

        return $this->calcularTotal();
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

        if(!isset($this->articulos[$producto])){
            return "El elemento a eliminar no esta en el inventario";
        }
        unset($this->articulos[$producto]);

        if($this->articulos === []){
        
            return "La lista ha sido vaciada";
        }

        return $this->listarInventario($this->articulos);
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
    private function calcularTotal(): string {
        $total = 0.0;
        foreach ($this->articulos as $producto => $cantidad) {
            $precio = $this->catalogo->getPrecio($producto);
            if ($precio !== null) {
                $total += $precio * $cantidad;
            }
        }
        // number_format garantiza que siempre devuelva dos decimales (ej: 0.00, 100.00)
        return "Total: " . number_format($total, 2, '.', '');
    }
}

interface Catalogo{
    public function getPrecio(string $articulo): ?float;
}   